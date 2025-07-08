<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\ContactForm; // モデルのインポート

class CsvDownloadController extends Controller
{
    public function export(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'id'); // デフォルトは'id'
        $direction = $request->input('direction', 'asc'); // デフォルトは'asc' 

        $query = ContactForm::search($search);

        $contacts = $query->orderBy($sort, $direction)->get();

        $callback = function() use ($contacts) {
            $handle = fopen('php://output', 'w');
            // ヘッダー行
            fputcsv($handle, ['ID', '氏名', '件名', 'メールアドレス', '登録日']);

            foreach ($contacts as $contact) {
                fputcsv($handle, [
                    $contact->id,
                    $contact->name,
                    $contact->title,
                    $contact->email,
                    $contact->created_at,
                ]);
            }
            fclose($handle);
        };
        $filename = 'contacts_' . now()->format('Ymd_His') . '.csv';
        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
