# DLRequest
get snippets parameters from $_REQUEST

```
[+paramsForm+]
<div>
[!DLRequest? &runSnippet=`DocLister` &parents=`2` &tpl=`@CODE:<p>[+id+]. [+pagetitle+]</p>` &paginate=`pages` &display=`0` 
//параметры и их возможные значения
&rqParams=`
	{
		"sortBy":{
			"id":"По id"
			,"pagetitle":"По pagetitle"
	}
		,"sortDir":{
			"asc":"По возрастанию"
			,"desc":"По убыванию"
		}
		,"display":{
			"1":"1 документ","3":"3 документа","5":"5 документов"
		}
	}
	`
//описания параметров
	&rqParamsNames=`
	{
		"sortBy":"Сортировать по"
		,"sortDir":"Порядок"
		,"display":"Результатов на странице"
	}
	`
	&selectedClassName=`selected`
	//плейсхолдер для вывода формы
	&paramsForm=`paramsForm`
	//можно сохранять произвольные параметры от других сниппетов
	&keepParams=`page`
	//шаблон формы 
	&paramsOwnerTPL=`@CODE
		<form method="get" action="[~[*id*]~]">
			[+keepParams+]
			[+params+]
			<button type="submit">Отправить</button>
		</form>
	`
	//общий для всех параметров шаблон
	&param.ownerTPL=`@CODE:
		<label>[+description+]</label><br>	
		<select name="[+paramName+]">
			[+values+]
		</select><br>
	`
	//общий шаблон для значений параметра
	&param.tpl=`@CODE:
		<option value="[+value+]" [+selectedClass+]>[+description+]</option>
	`
	//можно для каждого параметра задавать свои шаблоны
	&sortBy.tpl=`@CODE:
		<option value="[+value+]" [+selectedClass+]>[+description+] fghgh</option>
	`
	&display.ownerTPL=`@CODE:
		<label style="color:red;">[+description+]</label><br>	
		<select name="[+paramName+]">
			[+values+]
		</select><br>
	`
	//шаблон для внешних параметров
	&keepTpl=`@CODE:
		<input name="[+paramName+]" value="[+value+]" type="hidden">
	`
	
!]
</div>
[+pages+]
```
