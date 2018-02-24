<html lang="ja">


<!-HTML要素内のlang属性を日本語に指定->


<head>

<!-文書のタイトル等のヘッダ情報を記述->

<!-文字コードを助言するmetaタグを記載->
<meta http-equiv="content-type" charset="utf-8">

<!-文書にタイトルをつける->

<title>ゆるくまったりなブログ</title>

<!-ヘッダ情報を閉じる->
</head>

<!-body要素で文書の内容を表す->
<body>
<!-h3要素で見出し->
<h3>ゆるくまったりなブログ</h3>


<?php

//名前とコメントをブラウザで表示させる

//テキストファイル名を変数$filenameに代入する
	$filename='test.txt';

//$testと$userの中身を空にする（=nullでもできるよ!）
		$test="";

		$user="";

//$projectで編集2か入力フォームの入力のどちらかを判断できるようにする
		$project="rice yummy";

//*******************フォーム入力*************************

//$_POST['name']と$_POST['comment'](名前とコメント)が空じゃなければ{}内を実行
if(!empty($_POST['name'])&&!empty($_POST['comment'])&&!empty($_POST['password'])&&$_POST['project']=="rice yummy")
{
//$nameで名前を取得する。
	$name=$_POST['name'];
//$commentでコメントを取得する
	$comment=$_POST['comment'];
//投稿された年月日
	$date=date("Y-m-d h:i:s");
//$passwordでパスワードを取得する
	$password=$_POST['password'];
	
//fopenのaモード(追記モード)でファイルを開く(サーバにファイル名ないとエラー)
	$fp=fopen($filename,'a');

//投稿番号(配列の要素ひとつぶんの大きさ）、名前、コメント、年月日を$dataに代入
	$data=(sizeof(file($filename))+1)."<>".$name."<>".$comment."<>".$date."<>".$password."<>"."\n";

//入力フォームから入力された情報をfopenで開いたテキストファイルに代入する（書き込む）
	fwrite($fp,$data);

//fopenで開いたテキストファイルを閉じる
	fclose($fp);
}

//*******************削除*************************

//$_POST['name2']と$_POST['password']が空じゃなければ{}内を実行
if(!empty($_POST['name2'])&&!empty($_POST['password']))
{
//$namaeでpost送信で削除対象番号を取得する。
	$namae=$_POST['name2'];
	
	//$passwordでパスワードを取得する
	$password=$_POST['password'];

//file関数で$filename(テキストファイルの文字列)を配列にする($filenameのコピー)
	$lines=file($filename);

//書き込みモードで配列化したテキストファイルの文字列を開く
	$fp=fopen($filename,'w');

//ループ関数で繰り返し処理($linesの要素を同時に処理するのは大変、一個一個同じ処理する)
	foreach($lines as $i){

//explodeで文字を分割して取得
	$p=explode("<>",$i);

//変数が空なら何もしない
		if(empty($i)){
   		}
//そうでなければ削除番号と投稿番号が一致したら
		else if($p[0]==$namae)
		{
			//入力フォームで打ち込んだパスワードと削除フォームのパスワードが一致したら
			if($p[4]==$password)
			{
			//(投稿番号)削除しましたと書き込む
				fwrite($fp,$p[0]."削除しました\n");
			}
			//そうでなければ
			else
			{
			echo "パスワードが違います！！\n";
			//ファイルに$iの文字列を追記
				fputs($fp,$i);
			}
		//そうでなければ(削除番号と投稿番号が一致しなければ)ファイルに$iの文字列を追記
		}
		else
		{	 fputs($fp,$i);
		}

	}
}

//*******************編集1(編集番号を送信したら入力フォームに名前とコメントを呼び出して表示)*********************

//$_POST['name3']が空じゃなければ{}内を実行
if(!empty($_POST['name3'])&&!empty($_POST['password']))
{
	//$namでpost送信で編集対象番号を取得する。
	$nam=$_POST['name3'];
	//$passwordでパスワードを取得する
	$password=$_POST['password'];
	//file関数で$filename(テキストファイルの文字列)を配列にする
	$line=file($filename);
	
	//ループ関数で繰り返し処理（要素を一つ一つ処理）
	foreach($line as $m)
	{
		//explodeで文字を分割して取得
		$e=explode("<>",$m);
//編集したい番号と1つめの配列が一致したら
		if($e[0]==$nam){
		//入力フォームで打ち込んだパスワードと編集フォームのパスワードが一致したら
			if($e[4]==$password)
			{
			//名前とコメントを取得
				$edit=$e[0];

				$test=$e[1];

				$user=$e[2];
			
			//$projectで入力フォームではなく編集2を実行するように判断させる
				$project="udon";
			}
			//そうでなければ
			else
			{
			echo "パスワードが違います！！\n";
			}
				
		}

	}

}


//*******************編集2（編集番号を受信したら、その要素を書き換える）*********************
if($_POST['project']=="udon")
{
//$namでpost送信で編集対象番号を取得する。
	$nam=$_POST['edit'];

//file関数で$filename(テキストファイルの文字列)を配列にする
	$line=file($filename);

//書き込みモードで配列化したテキストファイルの文字列を開く
	$fp=fopen($filename,'w');


//ループ関数で繰り返し処理（要素を一つ一つ処理）
	foreach($line as $m)
	{
//explodeで文字を分割して取得
		$e=explode("<>",$m);

//編集番号と投稿番号が一致したら
		if($e[0]==$nam){
//名前とコメントを取得
		$edit=$e[0];

		$test2=$_POST['name'];

		$user2=$_POST['comment'];

		$date=$e[3];
		
		$password=$_POST['password'];

//$data=(sizeof(file($filename))+1).$name."<>".$comment."<>".$date."<>".$password."<>"."\n";
		$text=$edit."<>".$test2."<>".$user2."<>".$date."<>".$password."<>"."\n";

//名前とコメントを入力フォームで入力済みの状態で表示
		fputs($fp,$text);
//if以外でさらに空だったら何もしない
		}
		else if(empty($m))
		{
//ifでも　else　ifでもなければ、
		}
		else
		{
//テキストファイルの文字列を一つ一つ元通りに書き込む
		fputs($fp,$m);
	
		}

	}

//fopenで開いたテキストファイルを閉じる
	fclose($fp);

}


//***************入力フォーム*******************
?>

<form action="mission_2-6.php" method= "post">

<p>
名前
<!-input要素に１行のテキスト入力欄textを作成->
<input type="text" name="name" value="<?php echo $test;?>">
</p>

<!-改行->
<p>
コメント

<!-input要素に１行のテキスト入力欄textを作成->
<input type="text" name="comment" value="<?php echo $user;?>"/>

<!-input要素にname属性でフォーム部品の名前を指定->
<!-input要素にtype="submit"で送信ボタンを作成->

<!-input要素にhiddenでブラウザに投稿番号が表示されない(編集番号に0が指定されたとき、if文で使えないかも)->
<input name="edit" type="hidden" value="<?php echo $edit;?>"/>

<!-なので、$projectを目印にして編集2のときに確実に判定できるようにする＞
<!-input要素にhiddenでブラウザに投稿番号が表示されない->
<input name="project" type="hidden" value="<?php echo $project;?>"/>

<p>
パスワード
<!-パスワード入力欄を作成->
<!-input要素に１行のテキスト入力欄textを作成->
<input type="text" name="password" >

<!-input要素にvalue属性でボタンの値（ボタンに表示されるテキスト）を指定する->
<!-入力、送信フォームの作成->
<input type="submit" value="送信">
</p>


</form>

<!-action要素でデータの送信先を定義し、method要素でどのようにデータを送信するかを定義->
<form action="mission_2-6.php" method="post">
<p>
削除したい番号を入力
<!-input要素にname属性でフォーム部品の名前を指定->
<input type="text" name="name2">
</p>

<p>
パスワード
<!-パスワード入力欄を作成->
<!-input要素に１行のテキスト入力欄textを作成->
<input type="text" name="password" >

<!-input要素にname属性でフォーム部品の名前を指定->
<!-input要素にtype="submit"で送信ボタンを作成->
<!-input要素にvalue属性でボタンの値（ボタンに表示されるテキスト）を指定する->
<!-送信フォームの作成->
<input type="submit" value="送信">

</p>

</form>

<!-action要素でデータの送信先を定義し、method要素でどのようにデータを送信するかを定義->
<form action="mission_2-6.php" method="post">
<p>
編集したい番号を入力
<!-input要素にname属性でフォーム部品の名前を指定->
<input type="text" name="name3">

<p>
パスワード
<!-パスワード入力欄を作成->
<!-input要素に１行のテキスト入力欄textを作成->
<input type="text" name="password" >

<!-input要素にname属性でフォーム部品の名前を指定->
<!-input要素にtype="submit"で送信ボタンを作成->
<!-input要素にvalue属性でボタンの値（ボタンに表示されるテキスト）を指定する->
<!-入力、送信フォームの作成->
<input type="submit" value="送信">

</p>

</form>
</body>
</html>

<?php
//************ブラウザに表示*******************
//file関数で$filename(テキストファイルの文字列)を配列にする
	$lines=file($filename);

//ループ関数で繰り返し処理
	foreach($lines as $b){
	//explodeで文字を分割して取得
		$e=explode("<>",$b);
		
//$data=(sizeof(file($filename))+1).$name."<>".$comment."<>".$date."<>"."\n";
		$text=$e[0]." ".$e[1]." ".$e[2]." ".$e[3];
		
//echoでブラウザ表示させる
	echo $text."<br>";

}
?>

