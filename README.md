# Laravel Sample Project

Made By [tyamahori](https://twitter.com/tyamahori)

# 前提条件

- Mac(Intel/M1)を利用している
- Docker Desktop on Mac を利用している
- [FiloSottile/mkcert](https://github.com/FiloSottile/mkcert) をインストールしている

# hosts設定

デフォルトの場合

```
127.89.9.24 tyamahori.love
127.89.9.24 minio.tyamahori.love
127.89.9.24 schema.tyamahori.love
127.89.9.24 mail.tyamahori.love 
```

# 起動方法

```shell
$ cd docker/mac && ./mac create
```

# アプリケーション情報

| 項目名     | バージョン  |
| ---------- |--------|
| PHP        | 8.1.7  |
| Laravel    | 9.17.0 |
| PostgreSQL | 13.4   |
| Redis      | 6.0    |

# 開発ツール情報

| 項目名    | 備考 |
| ----      | ---- |
| Mailhog   | メールの確認ができます |
| Minio     | s3のローカルモックツールです |
| SchemaSpy | DBのあれこれを便利に確認できるツールです |

# DBアクセス情報

## 前提

- PostgreSQLを利用しています

## 接続情報

GUIツールなどでのアクセス設定で必要となります。

| 項目名   | 情報      |
| ----     | ----      |
| PORT     | 5432      |
| DATABASE | tyamahori |
| USERNAME | tyamahori |
| PASSWORD | tyamahori |
| SCHEMA   | tyamahori |

# 開発URL

| 項目名            | URL                                                            |
|----------------|----------------------------------------------------------------|
| Laravel        | https://tyamahori.love/                                        |
| SchemaSpy      | https://schema.tyamahori.love/                                 |
| Mailhog        | https://mail.tyamahori.love/                                   |
| Minio          | https://minio.tyamahori.love/ <br> ID: `tyamahori` Pass: `tyamahori` |
| Uploaded Files | https://file.tyamahori.love/tyamahori/*****                    |
