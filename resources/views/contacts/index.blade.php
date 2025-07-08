<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            お問い合わせ一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    index<br>
                    <a href="{{ route('contacts.create') }}" class="text-blue-500">新規登録</a><br>
                    <form class="mb-8" method="get" action="{{ route('contacts.index') }}">
                        <input type="text" name="search" placeholder="検索" value="{{ old('search', $search ?? '') }}">
                        <button class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">検索する</button>
                        <input type="hidden" name="sort" value="{{ $sort ?? 'id' }}">
                        <input type="hidden" name="direction" value="{{ $direction ?? 'asc' }}">
                    </form>
                    <a href="{{ route('contacts.export', request()->query())}}" class="text-blue-500 mb-4 inline-block">CSVダウンロード</a>
                    <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                    <table class="table-auto w-full text-left whitespace-no-wrap">
                        <thead>
                        <tr>
                            @php
                                $columns = [
                                    'id' => 'ID',
                                    'name' => '氏名',
                                    'title' => '件名',
                                    'created_at' => '登録日',
                                    'email' => 'メールアドレス',
                                ];
                            @endphp
                            @foreach($columns as $col => $label)
                                <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 {{ $loop->first ? 'rounded-tl rounded-bl' : '' }}">
                                    @php
                                        $isCurrent = ($sort ?? 'id') === $col;
                                        $nextDirection = ($isCurrent && ($direction ?? 'asc') === 'asc') ? 'desc' : 'asc';
                                        $arrow = $isCurrent ? (($direction ?? 'asc') === 'asc' ? '▲' : '▼') : '';
                                    @endphp
                                    <a href="{{ route('contacts.index', array_merge(request()->all(), ['sort' => $col, 'direction' => $nextDirection])) }}">
                                        {{ $label }} {!! $arrow !!}
                                    </a>
                                </th>
                            @endforeach
                            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">詳細</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($contacts as $contact)
                        <tr>
                            <td class="border-t-2 border-gray-200 px-4 py-3">{{ $contact->id }}</td>
                            <td class="border-t-2 border-gray-200 px-4 py-3">{{ $contact->name }}</td>
                            <td class="border-t-2 border-gray-200 px-4 py-3">{{ $contact->title }}</td>
                            <td class="border-t-2 border-gray-200 px-4 py-3">{{ $contact->created_at }}</td>
                            <td class="border-t-2 border-gray-200 px-4 py-3">{{ $contact->email_prefix }}</td>
                            <td class="border-t-2 border-gray-200 px-4 py-3"><a class="text-blue-500" href="{{ route('contacts.show', ['id' => $contact->id]) }}">詳細を見る</a></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                    {{ $contacts->appends(['search' => $search ?? '', 'sort' => $sort ?? 'id', 'direction' => $direction ?? 'asc'])->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
