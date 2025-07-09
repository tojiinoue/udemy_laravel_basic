# 📨 お問い合わせ管理アプリ（Laravel練習用）

Laravelの基礎構文および実務案件に必要な機能（CRUD・CSV出力・検索・バリデーション等）を習得するために作成した学習用アプリです。  
案件に備えて、PHPおよびLaravelの基本操作と構成の理解を深めることを目的としています。  

Docker＋Renderを使った本番環境構築まで対応しており、ローカル・クラウド両方で動作確認済みです。

---

## 📎 デモURL

🔗 [https://udemy-laravel-basic.onrender.com/contacts](https://udemy-laravel-basic.onrender.com/contacts)

※テスト用アカウントあり（下記参照）

---

## 🧪 テスト用アカウント

- Email: `test@example.com`  
- Password: `password123`

---

## 🛠 使用技術

| 項目         | 内容                             |
|--------------|----------------------------------|
| フレームワーク | Laravel 9.19                     |
| 言語         | PHP 8.2（Render環境）             |
| DB           | MySQL（Renderで外部接続）         |
| 認証         | Laravel Breeze                    |
| テンプレート | Blade                            |
| 本番環境     | Docker + Render（無料プラン）     |
| ローカル開発 | MAMP / Composer / VSCode         |

---

## ✅ 実装した主な機能（実務案件を想定）

- ログイン・ログアウト（Breeze使用）
- お問い合わせ一覧／新規登録／編集／削除（基本のCRUD処理）
- 氏名・メール・内容によるAND検索（複数ワード対応）
- 各カラムごとの昇順／降順の並び替え
- ページネーション（20件ずつ）
- アクセサ使用：一覧でメールの@前のみ表示
- CSV出力機能（検索・ソート状態を反映）
- Featureテスト（Store処理のみ実装済み）

---

## 🧱 ローカル開発用セットアップ

```bash
git clone https://github.com/tojiinoue/udemy_laravel_basic.git
cd udemy_laravel_basic

# PHP系
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

# フロント系（CSS反映に必要）
npm install
npm run build

php artisan serve
# → http://localhost:8000 にアクセス
````

---

## 🔧 今後の改修予定（実務スキル向上を目的）

* ソフトデリート（論理削除）対応
* 管理者ロールによるアクセス制御（Gate／Policy学習）
* スケジュールバッチ処理の追加
* CSVインポート機能
* REST API対応（一覧取得／登録等）
* ユニットテスト強化（Controller／Service単位）

---

## 📝 補足：本番環境構築に関する学び

DockerとRenderを使って初めて本番環境を構築しました。特に下記の点に注意・対応しています：

* CSSはViteでビルド → `public/build` を Git に含める必要あり
* `.env` の `APP_URL` は必ず `https://` に設定
* CSRFエラー対策として `URL::forceScheme('https')` を明示的に指定
* CSVは `response()->streamDownload()` を使ってRenderでも動作確認済み

---

## 📈 学習の成果まとめ

* Laravelの基本構文（ルーティング、Controller、Model、View）と開発フローを理解
* バリデーションやクエリ検索、CSV出力など、実務でよく使われる機能を一通り経験
* Docker／Renderを用いた本番環境構築で、環境差異や公開時の注意点も把握

---

## 🔗 参考リンク

* 📘 Laravel公式ドキュメント（9.x）
    👉 [https://readouble.com/laravel/9.x/ja/](https://readouble.com/laravel/9.x/ja/)

* 🎓 Udemy教材：Laravel入門講座
    👉 [https://www.udemy.com/share/102CWj3@-LuLq3ocIrjXXQ\_SB\_H\_oq3Y\_5BuOOXoQQvl51Dl2AvsiW-zaICeLI4VbOHQnKQgqw==/](https://www.udemy.com/share/102CWj3@-LuLq3ocIrjXXQ_SB_H_oq3Y_5BuOOXoQQvl51Dl2AvsiW-zaICeLI4VbOHQnKQgqw==/)
