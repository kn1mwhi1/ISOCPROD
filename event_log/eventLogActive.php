<?php
require_once 'lib/Class_Event_Logic.php';
$tierTwo = new Event_Logic();


	echo '
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-table.css">
<script src="script/jquery.js"></script>
<script src="script/bootstrap.min.js"></script>
<script src="script/bootstrap-table.js"></script>


	
	        <table id="table"
               data-toggle="table"
               data-height="460"
               data-search="true"
			   >		
			 
       
	
	
	<thead>
			<tr>
				<th data-field="Name" data-sortable="true">Name</th>
				<th data-field="Stars" data-sortable="true">Stars</th>
				<th data-field="Forks" data-sortable="true">Forks</th>
				<th data-field="Description" data-sortable="true">Description</th>
			</tr>
            </thead>
	
	
	
	<tbody>
	
        <tr >
            <td id="td-id-1" class="td-class-1" data-title="bootstrap table">
                <a href="https://github.com/wenzhixin/bootstrap-table">bootstrap-table</a>
            </td>
            <td data-value="526">526</td>
            <td data-text="122">122</td>
            <td data-i18n="Description">An extended Bootstrap table with radio, checkbox, sort, pagination, and other added features. (supports twitter bootstrap v2 and v3)
            </td>
        </tr>
        <tr >
            <td id="td-id-2" class="td-class-2">
                <a href="https://github.com/wenzhixin/multiple-select">multiple-select</a>
            </td>
            <td>288</td>
            <td>150</td>
            <td>A jQuery plugin to select multiple elements with checkboxes :)
            </td>
        </tr>
        <tr >
            <td id="td-id-3" class="td-class-3">
                <a href="https://github.com/wenzhixin/bootstrap-show-password">bootstrap-show-password</a>
            </td>
            <td>32</td>
            <td>11</td>
            <td>Show/hide password plugin for twitter bootstrap.
            </td>
        </tr>
        <tr id="tr-id-4" class="tr-class-4">
            <td id="td-id-4" class="td-class-4">
                <a href="https://github.com/wenzhixin/blog">blog</a>
            </td>
            <td>13</td>
            <td>4</td>
            <td>my blog</td>
        </tr>
        <tr id="tr-id-5" class="tr-class-5">
            <td id="td-id-5" class="td-class-5">
                <a href="https://github.com/wenzhixin/scutech-redmine">scutech-redmine</a>
            <td>6</td>
            <td>3</td>
            <td>Redmine notification tools for chrome extension.</td>
        </tr>
        </tbody>
	 </table>'
		;
?>