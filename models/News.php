<?php


class News
{
	/*
	Возвращает одну новость по слецияльному идентификатору
	@param integer $id
	*/
	public static function getNewsItemsById($id)
	{
		$id = intval($id);

		if($id)
		{
			try
			{
				$db = db::getConnection();
			}
			catch(PDOException $e)
			{
				echo 'Не получилось подключиться к БД  ';
				echo $e->getMessage();
				die();
			}
			$result = $db->query('SELECT * FROM news WHERE id=' . $id);

			//$resutl->setFetchMode(PDO::FETCH_NUM);
			$result->setFetchMode(PDO::FETCH_ASSOC);

			$newsItem = $result->fetch();

			return $newsItem;
		}
	}


	/*
	Возвращает список новостей в массиве
	*/
	public static function getNewsList()
	{
		try
		{
			$db = db::getConnection(); //Вызов статического метода для подключения к БД
		}
		catch(PDOException $e)
		{
			echo 'Не получилось подключиться к БД  ';
			echo $e->getMessage();
			die();
		}

		$newsList = array(); //массив результатов

		//С помощью подключения к БД выполныется запрос к БД на вывод данных из таблици news, с сортировкой по дате, и на лимит в 10 строк
		$result = $db->query('SELECT id, title, date, short_content FROM news ORDER BY date DESC LIMIT 10'); 

		$i = 0;

		while($row = $result->fetch()) //с помощью цыкла while производится выборка из переменной $result по порядку элемент за элементом с помощью метода для выборки fetch и эти данных записываются в ассоцыативный массив $row где ассоциацыей является название столбца в БД
		{
			$newsList[$i]['id'] = $row['id'];
			$newsList[$i]['title'] = $row['title'];
			$newsList[$i]['date'] = $row['date'];
			$newsList[$i]['short_content'] = $row['short_content'];
			$i++;
		}

		return $newsList;
	}
}