<html lang="ja">

<!-HTML要素内のlang属性を日本語に指定->

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
//FTPアカウントの「-」と「.」を「_」に変更
$dsn = 'mysql:dbname=データベース名;host=localhost';
//ユーザー名
$user = 'ユーザー名';
//FTPアカウントのパスワード
$password = 'パスワード';
/*データベース接続クラス(変数と関数の集まり)を使用し、同じ命令でどのデータベースにも接続できるようにする
//どのデータベースを使っているかは隠ぺい*/
$pdo = new PDO($dsn, $user, $password);
/*SQLコマンドCREATE TABLEで新規テーブル(中身をいれる枠,表のようなもの)を作成(カラーボックスのようなもの)
//MYSQLにデータを保存させる場所を確保
$sql= "CREATE TABLE colorbox"//colorboxはテーブル名
//MYSQLになにを保存するかを定義する
." ("
."id INT,"//id(変数名) INT(変数の中身の種類を決めるもの),INTは中身が数字
."name char(32),"//char()は中身が文字または数字の長さが短いもの、カッコ内が文字数制限
."comment TEXT,"//TEXTはcharと違って文字の制約がない
."date DATETIME,"//DATETIMEは日付と時間の範囲の制約がほとんどない
."password TEXT"
.");";

(こんなふうに表示されるよ！)
id1 name1 comment1 datetime1 password1
id2 name2 comment2 datetime2 password2
id3 name3 comment3 datetime3 password3
・  ・   ・     ・      ・
・  ・   ・     ・      ・
・  ・   ・     ・      ・

//テーブル一覧を表示するコマンドを使って作成が出来たか確認する
$sql ='SHOW TABLES';
$result = $pdo -> query($sql);
foreach ($result as $row){
 echo $row[0];
 echo '<br>';
}
echo "<hr>";

//テーブルの中身を確認するコマンドを使って、意図した内容のテーブルが作成されているか確認する
$sql ='SHOW CREATE TABLE colorbox';
$result = $pdo -> query($sql);//クエリーを実行し、結果の値を$resultに入れる
	foreach ($result as $row){//$resultの値が配列だったらforeachが実行できる
 	print_r($row); 
	}
echo "<hr>";
*/
//$testと$userの中身を空にする（=nullでもできるよ!）
		$test="";
		$user="";
//$projectで編集2か入力フォームの入力のどちらかを判断できるようにする
		$project="rice yummy";

//*******************フォーム入力*************************

//$_POST['name']と$_POST['comment'](名前とコメント)が空じゃなければ{}内を実行
if(!empty($_POST['name'])&&!empty($_POST['comment'])&&!empty($_POST['password'])&&$_POST['project']=="rice yummy")
{
	
	/*colorboxテーブルの中身をひとかたまりを一要素として$resultsに一行ずつ入れるコマンド($sql)を実行。
	結果の値を$resultに入れる。(idやnameなどの要素が全部くっついている状態)*/
	$sql = 'SELECT * FROM colorbox';
	$results = $pdo -> query($sql);
	//$idがemptyだったら投稿番号は0（$id++で投稿番号は1から始まる）
	if(empty($results))
	{
		$id=0;
	}
	//そうでなければ
	else{
	
	//ループ関数で繰り返し処理($resultsのくっついている要素を$rowに入れてひとつひとつ分解する)
	foreach ($results as $row){
   //$rowの中にはテーブルのカラム名(colorboxの要素。idとかname)が入る
	 $id = $row['id'];//最後の投稿番号
	}
	}
	/*
	$sqlは追記の準備のコマンド
	(テーブルのid,name,comment,date,passwordの処理が一度のデータベースへのアクセスでできる)
	*/
	$sql=$pdo->prepare("INSERT INTO colorbox (id,name,comment,date,password) VALUES(:id,:name,:comment,:date,:password)"); //VALUESの中身は仮の入れ物(:が目印)
	//VALUEに入れた仮の入れ物に本物の変数名をいれる（:nameに$nameをくくりつけることで、あとから$nameが使われることを表す）
	$sql->bindParam(':id',$id,PDO::PARAM_STR);
	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	$sql->bindParam(':comment',$comment,PDO::PARAM_STR);//上と同様
	$sql->bindParam(':date',$date,PDO::PARAM_STR);
	$sql->bindParam(':password',$password,PDO::PARAM_STR);
	
	//投稿番号を一個ずつ増やす（$id=$id+1;$id+=1;）
	$id++;
	//$nameで名前を取得する。
	$name=$_POST['name'];
	//$commentでコメントを取得する
	$comment=$_POST['comment'];
	//投稿された年月日
	$date=date("Y-m-d h:i:s");
	//$passwordでパスワードを取得する
	$password=$_POST['password'];
	//実行して追記
	$sql->execute();

}

//*******************削除*************************

//$_POST['name2']と$_POST['password']が空じゃなければ{}内を実行
if(!empty($_POST['name2'])&&!empty($_POST['password']))
{
//$idでpost送信で削除対象番号を取得する。
	$id=$_POST['name2'];
	//$passwordでパスワードを取得する
	$password=$_POST['password'];

	/*colorboxテーブルの中身をひとかたまりを一要素として$resultsに一行ずつ入れるコマンド($sql)を実行。
	結果の値を$resultに入れる。(idやnameなどの要素が全部くっついている状態)*/
	$sql = 'SELECT * FROM colorbox';
	$results = $pdo -> query($sql);

//ループ関数で繰り返し処理($resultsの要素を同時に処理するのは大変、一個一個同じ処理する)
	foreach($results as $i){
//変数が空なら何もしない
		if(empty($results)){
   		}
//そうでなければ投稿番号と削除番号が一致したら
		else if($i['id']==$id)
		{
			//入力フォームで打ち込んだパスワードと削除フォームのパスワードが一致したら
			if($i['password']==$password)
			{
			//削除番号が一致している文を消す
			$sql = "delete from colorbox where id=$id";
			//$sqlを実行！
			$result = $pdo->query($sql);
			}
			//そうでなければ
			else
			{
			echo "パスワードが違います！！\n";
			
			}
		
		}

	}
}

//*******************編集1(編集番号を送信したら入力フォームに名前とコメントを呼び出して表示)*********************

//$_POST['name3']が空じゃなければ{}内を実行
if(!empty($_POST['name3'])&&!empty($_POST['password']))
{
	//$id2でpost送信で編集対象番号を取得する。
	$id2=$_POST['name3'];
	//$passwordでパスワードを取得する
	$password=$_POST['password'];
	
	/*colorboxテーブルの中身をひとかたまりを一要素として$resultsに一行ずつ入れるコマンド($sql)を実行。
	結果の値を$resultに入れる。(idやnameなどの要素が全部くっついている状態)*/
	$sql = 'SELECT * FROM colorbox';
	$results = $pdo -> query($sql);
	
	//ループ関数で繰り返し処理（要素を一つ一つ処理）
	foreach($results as $m)
	{
//編集したい番号と1つめの配列が一致したら
		if($m['id']==$id2){
		//入力フォームで打ち込んだパスワードと編集フォームのパスワードが一致したら
			if($m['password']==$password)
			{
			//名前とコメントを取得
				$edit=$m['id'];

				$test=$m['name'];

				$user=$m['comment'];
			
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
//$idでpost送信で編集対象番号を取得する。
	$id=$_POST['edit'];

/*colorboxテーブルの中身をひとかたまりを一要素として$resultsに一行ずつ入れるコマンド($sql)を実行。
	結果の値を$resultに入れる。(idやnameなどの要素が全部くっついている状態)*/
	$sql = 'SELECT * FROM colorbox';
	$results = $pdo -> query($sql);
	
//ループ関数で繰り返し処理（要素を一つ一つ処理）
	foreach($results as $m)
	{

//編集番号と投稿番号が一致したら
		if($m['id']==$id){
		//名前とコメントとパスワードを取得
		
		$test2=$_POST['name'];

		$user2=$_POST['comment'];
		
		$password=$_POST['password'];
		
		//update(編集)対象にcolorboxを指定して、setで編集する要素を指定。where idでどの編集番号を編集するかを指定
		$sql = "update colorbox set name='$test2', comment='$user2', password='$password' where id = $id"; 
		//実行
		$result = $pdo->query($sql);
		
		}
	

	}


}


//***************入力フォーム*******************
?>

<form action="mission_2-15.php" method= "post">

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
<form action="mission_2-15.php" method="post">
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
<form action="mission_2-15.php" method="post">
<p>
編集したい番号を入力
<!-input要素にname属性でフォーム部品の名前を指定->
<input type="text" name="name3">
</p>

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
	$sql = 'SELECT * FROM colorbox';
	$results = $pdo -> query($sql);
	/*colorboxテーブルの中身をひとかたまりを一要素として$resultsに一行ずつ入れるコマンド($sql)を実行。
	結果の値を$resultに入れる。(idやnameなどの要素が全部くっついている状態)*/
	
	//ループ関数で繰り返し処理($resultsのくっついている要素を$rowに入れてひとつひとつ分解する)
	foreach ($results as $row){
   //$rowの中にはテーブルのカラム名(colorboxの要素。idとかname)が入る
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['date'].'<br>';
	}
/*参考
	foreach($results as $b){
	//explodeで文字を分割して取得
	$e=explode("<>",$b);
	//$data=(sizeof(file($filename))+1).$name."<>".$comment."<>".$date."<>"."\n";
	$text=$e[0]." ".$e[1]." ".$e[2]." ".$e[3];
	//echoでブラウザ表示させる
	echo $text."<br>";
*/

?>


