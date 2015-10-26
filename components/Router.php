<?php

class Router
{
	private $routes;

	public function __construct()
	{
		$routesPath = ROOT . '/config/routes.php';
		$this->routes = include($routesPath);
	}


	/*
	Возвращает строку запроса url
	@return string
	*/
	private function getURI()
	{
		if(!empty($_SERVER['REQUEST_URI'])) //Проверяем получен ли какой нибудь адресс url
		{
			return trim($_SERVER['REQUEST_URI'], '/');
		}
	}

	public function run()
	{
		//Получить строку запроса
		$uri = $this->getURI();

		//Проверить наличие такого запроса в routes.php
		foreach($this->routes as $uriPattern => $path)
		{
			//Сравниваем $uriPattern и $uri
			if(preg_match("~$uriPattern~", $uri))
			{
				//Получаем внуттренний путь из внешнего согласно правилу
				$internalRouter = preg_replace("~$uriPattern~", $path, $uri); //Выполняет поиск совпадений $uriPattern с $uri и если они есть заменяет их на то что в $path

				//Определить контроллер, action, параметры
				$segments = explode('/', $internalRouter);

				$controllerName = array_shift($segments) . 'Controller';
				$controllerName = ucfirst($controllerName);

				$actionName = 'action' . ucfirst(array_shift($segments));

				$parameter = $segments;

				//Подключить файл класса-контроллера
				$controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

				if(file_exists($controllerFile))
				{
					include_once($controllerFile);
				}
				//Создать обьект и вызвать метод (т.е. action)
				$controllerObject = new $controllerName;

				$result = call_user_func_array(array($controllerObject, $actionName), $parameter);
				//$result = $controllerObject->$actionName($parameter);

				if($result != null)
				{
					break;
				}
			}
		}





















/*
		**В этом методе мы должны**

		*Получить строку запроса
		*Проверить наличие такого запроса в routes.php
		*Если есть совпадение, определить какой котроллер и action обрабатывают запрос
		*Полключить файл класса-котроллера
		*Создать обьект, вызвать метод (т.е. action)

*/
/*		//Получаем строку запроса
		$uri = $this->getURI();
		

		//Проверяем наличие такого запроса
		foreach($this->routes as $uriPattern => $path){

			//Сравниваем $uriPattern и $uri
			if(preg_match("~$uriPattern~", $uri))
			{

				//Определить какой контроллер и action
				//Обрабатывают запрос

				$segments = explode('/', $path); //Разделяет строку на две части образуя массив 

				$controllerName = array_shift($segments) . 'Controller'; //Удаляет из массива первый элемент и соединяет его со строкой 'Controller'
				$controllerName = ucfirst($controllerName); //преобразуем первую букву полученой строки в верхний регистр
				
				$actionName = 'action' . ucfirst(array_shift($segments)); //Удаляте из массива $segments оставшийся элемент преобразует его первыую букву в верхний регистр и добавлят к нему в начало строку "action"


				//Подключить файл класса-контроллера
				$controllerFile = ROOT . '/controllers/' . $controllerName . '.php'; //Определяет файл который нужно подключить, прописываем путь к нему используя имя класса

				if(file_exists($controllerFile))//Проверяем существует ли вообще файл с таким именем
				{
					include_once($controllerFile);//И если да то просто подключаем его
				}


				//Создать обьект, вызвать метод (т.е. action)
				$controllerObject = new $controllerName; //Создаем обьект класса контроллера, и вместо имени класса подставляем строку которая содержит строку с именем этого класса
				$result = $controllerObject->$actionName(); //Для этого обьекта вызывается метод, используя переменную которая содержит строку с названием нужного метода
				if($result != null) //Проверка если метод сработал и переменная $result не пуста
				{
					break;// И если метод сработал мы можем оборвать этот цыкл foreach который ищет совпадения в наших маршрутах
				}
			}
		}*/
	}
}