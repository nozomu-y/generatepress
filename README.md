# GeneratePress
OVページで用いているWordPressテーマです。

## Installation

#### Wordpressのダウンロード
```
mkdir ovpage  # ovpage 以外でも良い
cd ovpage
wp core download --locale=ja
```

#### データベース設定
1. MySQLで空のデータベースを作成してください。
1. 設定ファイルを複製してください。
    ```
    cp wp-config-sample.php wp-config.php
    ```
1. `wp-config.php` を開き、データベース情報を設定してください。（環境によって値が異なるので注意）
    
    ```php
    // ** データベース設定 - この情報はホスティング先から入手してください。 ** //
    /** WordPress のためのデータベース名 */
    define( 'DB_NAME', 'database_name_here' );
    
    /** データベースのユーザー名 */
    define( 'DB_USER', 'username_here' );
    
    /** データベースのパスワード */
    define( 'DB_PASSWORD', 'password_here' );
    
    /** データベースのホスト名 */
    define( 'DB_HOST', 'localhost' );
    ```

ここまで終わるとWordPressのサイトが閲覧できるようになります。
localhostでovpageのサイトを開いてください。

#### WordPressのインストール
サイトを開いたら、必要情報を入力してWordPressをインストールしてください。  
サイトのタイトルは `Chor Kleines OV Page`、ユーザー名やパスワードは自由に設定してください。

インストールが完了したら設定したユーザー名とパスワードでログインしてください。


#### プラグインのインストール

管理画面から以下のプラグインをインストールして有効にして下さい。

* [all-in-one-wp-migration](https://ja.wordpress.org/plugins/all-in-one-wp-migration/)
* [bbpress](https://ja.wordpress.org/plugins/bbpress/)
* [breadcrumb-navxt](https://ja.wordpress.org/plugins/breadcrumb-navxt/)
* [custom-post-type-ui](https://ja.wordpress.org/plugins/custom-post-type-ui/)
* [font-awesome](https://ja.wordpress.org/plugins/font-awesome/)
* [gd-bbpress-attachments](https://ja.wordpress.org/plugins/gd-bbpress-attachments/)

#### テーマのインストール

```
cd wp-content/themes
git clone git@github.com:your-username/generatepress.git
cd generatepress
```

管理画面からGeneratePressを有効にしてください。
