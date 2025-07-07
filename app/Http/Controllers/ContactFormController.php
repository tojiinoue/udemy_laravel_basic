<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactForm;
use App\Services\CheckFormService;
use App\Http\Requests\StoreContactRequest;

class ContactFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $sort = $request->input('sort', 'id'); // デフォルトはid
        $direction = $request->input('direction', 'asc'); // デフォルトは昇順

        // 並べ替え可能なカラムのみ許可
        $allowedSorts = ['id', 'name', 'title', 'created_at', 'email'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }
        $allowedDirections = ['asc', 'desc'];
        if (!in_array($direction, $allowedDirections)) {
            $direction = 'asc';
        }

        $query = ContactForm::search($search);
        $perPage = 20;

        if ($sort === 'name') {
            // DBから全件取得し、コレクションで五十音順ソート
            $all = $query->select('id', 'name', 'title', 'created_at')->get();
            $sorted = $all->sortBy(function($item) {
                // mb_convert_kanaでカタカナ変換し、五十音順で比較
                return mb_convert_kana($item->name, 'C');
            }, SORT_REGULAR, $direction === 'desc');
            // ページネーション手動
            $page = $request->input('page', 1);
            $contacts = new \Illuminate\Pagination\LengthAwarePaginator(
                $sorted->slice(($page - 1) * $perPage, $perPage)->values(),
                $sorted->count(),
                $perPage,
                $page,
                [
                    'path' => $request->url(),
                    'query' => $request->query(),
                ]
            );
        } else {
            $contacts = $query->select('id', 'name', 'title', 'created_at', 'email')
                ->orderBy($sort, $direction)
                ->paginate($perPage)
                ->appends(['search' => $search, 'sort' => $sort, 'direction' => $direction]);
        }

        return view('contacts.index', compact('contacts', 'sort', 'direction', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request)
    {
        ContactForm::create([
            'name' => $request->name,
            'title' => $request->title,
            'email' => $request->email,
            'url' => $request->url,
            'gender' => $request->gender,
            'age' => $request->age,
            'contact' => $request->contact,
        ]);
        return to_route('contacts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = ContactForm::find($id);

        $gender = CheckFormService::checkGender($contact);

        $age = CheckFormService::checkAge($contact);

        return view('contacts.show', compact('contact', 'gender', 'age'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = ContactForm::find($id);
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contact = ContactForm::find($id);
        $contact->name = $request->name;
        $contact->title = $request->title;
        $contact->email = $request->email;
        $contact->url = $request->url;
        $contact->gender = $request->gender;
        $contact->age = $request->age;
        $contact->contact = $request->contact;
        $contact->save();

        return to_route('contacts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = ContactForm::find($id);
        $contact->delete();
        return to_route('contacts.index');
    }
}
