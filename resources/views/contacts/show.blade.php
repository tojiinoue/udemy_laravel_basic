<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            詳細画面
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <section class="text-gray-600 body-font relative">
                    <div class="container px-5 mx-auto">
                        <div class="lg:w-1/2 md:w-2/3 mx-auto">
                        <div class="flex flex-wrap -m-2">
                            <div class="p-2 w-full">
                            <div class="relative">
                                <label for="name" class="leading-7 text-sm text-gray-600">氏名</label>
                                <div class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $contact->name }}</div>
                            </div>
                            </div>

                            <div class="p-2 w-full">
                            <div class="relative">
                                <label for="title" class="leading-7 text-sm text-gray-600">件名</label>
                                <div class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $contact->title }}</div>
                            </div>
                            </div>

                            <div class="p-2 w-full">
                            <div class="relative">
                                <label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
                                <div class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $contact->email }}</div>
                            </div>
                            </div>

                            <div class="p-2 w-full">
                            <div class="relative">
                                <label for="url" class="leading-7 text-sm text-gray-600">ホームページ</label>
                                @if($contact->url)
                                <div class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $contact->url }}</div>
                                @endif
                            </div>
                            </div>

                            <div class="p-2 w-full">
                            <div class="relative">
                                <label for="gender" class="leading-7 text-sm text-gray-600">性別</label>
                                <div class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $gender }}</div>
                            </div>
                            </div>

                            <div class="p-2 w-full">
                            <div class="relative">
                                <label for="age" class="leading-7 text-sm text-gray-600">年齢</label>
                                <div class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $age }}</div>
                            </div>
                            </div>

                            <div class="p-2 w-full">
                            <div class="relative">
                                <label for="contact" class="leading-7 text-sm text-gray-600">お問い合わせ内容</label>
                                <div class="w-full rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-6 transition-colors duration-200 ease-in-out">{{ $contact->contact }}</div>
                            </div>
                            </div>

                            <form method="get" action="{{ route('contacts.edit', ['id'=>$contact->id ])}}">
                            <div class="p-2 w-full">
                            <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">編集する</button>
                            </div>
                            </form>

                            <form id="delete_{{ $contact->id }}" class="mt-40" method="post" action="{{ route('contacts.destroy', ['id'=>$contact->id ])}}">
                                @csrf
                            <div class="p-2 w-full">
                            <a href="#" data-id="{{ $contact->id }}" onclick="deletePost(this)" class="flex mx-auto text-white bg-pink-500 border-0 py-2 px-8 focus:outline-none hover:bg-pink-600 rounded text-lg">削除する</a>
                            </div>
                            </form>
                        </div>
                        </div>
                    </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
<script>
    function deletePost(e){
        'use strict'
        if(confirm('本当に削除してもいいですか？')){
            document.getElementById('delete_' + e.dataset.id).submit()
        }
    }
</script>
</x-app-layout>
