<?php
// CORS（Cross-Origin Resource Sharing）ヘッダー設定
// "https://lgqqi65169.rakkoserver.net"からのアクセスを許可
header('Access-Control-Allow-Origin: https://lgqqi65169.rakkoserver.net/index');
// json形式でデータ送信
header('Content-Type: application/json');

// ディレクトリの絶対パス指定
$directory = $_SERVER['DOCUMENT_ROOT'] . '/work-product/';

// ファイルリストを格納する配列
$file_list = [];

// ディレクトリが存在しているかチェック
if(is_dir($directory)){
    
    // 取得したファイルから、'.' と '..' を削除
    $files = array_diff(scandir($directory), ['.', '..']);
    
    // 取得したファイルをURLに変換するためforeachで展開。
    foreach($files as $file) {
        
        // WEB上のルートURL + ファイル名 でURL生成
        $base_url = 'https://lgqqi65169.rakkoserver.net/work-product/';
        $file_url = $base_url . urlencode($file);

        // 取得したファイルを配列に格納
        $file_list[] = [
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

?>