# Measuring lazy loading

このプロジェクトは、データベースの全レコードを一括で取得する方式（Eager Loading）と、自作のIteratorを用いて1件ずつ取得する遅延読み込み方式（Lazy Loading）のメモリ消費量の違いを実証するものです。

## 実行方法

1.  環境を起動します:
    ```bash
    docker-compose up -d --build
    ```
2.  DBに10万件のデータを投入します:
    ```bash
    docker-compose exec php php scripts/seed.php
    ```
3.  テストスクリプトを実行します:
    *   **一括読み込み:** `docker-compose exec php php bad_run.php`
    *   **遅延読み込み:** `docker-compose exec php php good_run.php`

## 実験結果

`items`テーブルに10万件のレコードがある状態で実験を行いました。

| 読み込み方式                | 最大メモリ使用量 (MB) |
| --------------------------- | ----------------------:|
| 一括読み込み (`fetchAll`)   |               60.75 MB |
| 遅延読み込み (`Iterator`)   |               ~0.52 MB |

## 結論

自作の`Iterator`を用いた遅延読み込みは、`PDO::fetchAll`で全件を一括取得する方法と比較して、ピーク時のメモリ使用量を99%以上という劇的に削減します。これは、大量のデータセットをメモリ不足に陥ることなく処理する必要があるアプリケーションにとって、不可欠なパターンです。
