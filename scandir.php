<?php
// CORS（Cross-Origin Resource Sharing）ヘッダー設定
// "https://lgqqi65169.rakkoserver.net"からのアクセスを許可
header('Access-Control-Allow-Origin: https://lgqqi65169.rakkoserver.net');
// json形式でデータ送信
header('Content-Type: application/json');

// echo $_SERVER['DOCUMENT_ROOT'];
$directory = $_SERVER['DOCUMENT_ROOT'] . '/work-product/';
// WEB上のルートURL。「$base_url」+「ファイル名」でURLの生成。
$base_url = 'https://lgqqi65169.rakkoserver.net/work-product/';

// ファイルリストを格納する配列
$file_list = [];

// ディレクトリが存在しているかチェック
if(is_dir($directory)){
    // ディレクトリが存在していた場合の処理
    
    // 取得したファイルから、'.' と '..' を削除
    $files = array_diff(scandir($directory), ['.', '..']);
    // var_dump($files);

    // 取得したファイルをURLに変換するためforeachで展開。
    foreach($files as $file) {
        // var_dump($file);

        // ファイル名に使用された特殊文字をURL用にエンコード
        $file_url = $base_url . urlencode($file);
        // var_dump($file_url);

        // 取得したファイルを配列に格納
        $file_list[] = [
            // 連想配列（キー）を指定
            'name' => $file,
            'url' => $file_url
        ];
    }
    // ディレクトリが存在していた場合は、$file_listの配列を返す
    echo json_encode([
        'result' => true,
        'files' => $file_list
    ]);
} else {
    // ディレクトリが存在しない場合のエラーレスポンス
    echo json_encode([
        'result' => false,
        'message' => '指定されたディレクトリが見つかりません。'
    ]);
}
// var_dump($file_url);
// var_dump($file_list);

?>