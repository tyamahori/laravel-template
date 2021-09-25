# Laravel Sample Project

Made By [tyamahori](https://twitter.com/tyamahori)

# 前提条件

- Macを利用している
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


# DBアクセス情報

## 前提

GUIツールなどでのアクセス設定で必要となります。

- PostgreSQL 13.4

## 接続情報

|  項目名  |  情報  |
| ---- | ---- |
|  PORT  |  5432  |
|  DATABASE  |  tyamahori  |
|  USERNAME  |  tyamahori  |
|  PASSWORD  |  tyamahori  |
|  SCHEMA  |  tyamahori  |
