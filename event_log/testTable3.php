<!--  view-source:http://issues.wenzhixin.net.cn/bootstrap-table/index.html  -->

<html>
<head>

<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-table.css">
<script src="script/jquery.js"></script>
<script src="script/bootstrap.min.js"></script>
<script src="script/bootstrap-table.js"></script>
<!--
<script>
    var $table = $('#table'),
        $button = $('#button');

    $(function () {
        $button.click(function () {
            $table.bootstrapTable('refresh');
        });
    });
</script>
-->


</head>
<body>

 <div id="toolbar">
            <button id="button" class="btn btn-default">refresh</button>
        </div>
  <div class="container">
        <table id="table"
               data-toggle="table"
               data-height="460"
               data-ajax="ajaxRequest"
               data-search="true"
               data-side-pagination="server"
               data-pagination="true"
				data-url="example/json/data1.json"
			   >
            <thead>
            <tr>
                <th data-field="state" data-checkbox="true"> CheckBox</th>
				<th data-field="id" data-sortable="true" >Item ID</th>
                <th data-field="name" data-sortable="true">Item Name</th>
                <th data-field="price" data-sortable="true" data-sorter="priceSorter">Item Price</th>
            </tr>
            </thead>
        </table>
    </div>

	<!--
	$('#table').bootstrapTable({
    columns: [{
        field: 'id',
        title: 'Item ID'
    }, {
        field: 'name',
        title: 'Item Name'
    }, {
        field: 'price',
        title: 'Item Price'
    }],
    data: [{
        id: 1,
        name: 'Item 1',
        price: '$1'
    }, {
        id: 2,
        name: 'Item 2',
        price: '$2'
    }]
});
	
-->
	

<!--

var timeOutId = 0;
var ajaxFn = function () {
        $.ajax({
            url: 'example/json/data1.json',
            success: function (response) {
                if (response == 'True') {
                    clearTimeout(timeOutId);
                } else {
                    timeOutId = setTimeout(ajaxFn, 1000);
                    console.log("call");
                }
            }
        });
}
ajaxFn();

 var $table = $('#table');

    // custom your ajax request here
    function ajaxRequest(params) 
	{
        // data you need
        console.log(params.data);
        // just use setTimeout
        setTimeout(function () {
            params.success(
			{
                total: 100,
                rows: [{
                    "id": 0,
                    "name": "Item 0",
                    "price": "$0"
                }]
            });
			
            // hide loading
            params.complete();
        }, 1000);
    }


-->	
<script>
    var $table = $('#table');

    // custom your ajax request here
    function ajaxRequest(params) {
        // data you need
        console.log(params.data);
        // just use setTimeout
        setTimeout(function () {
            params.success({
                total: 100,
                rows: [{
                    "id": 0,
                    "name": "Item 0",
                    "price": "$0"
                }]
            });
            // hide loading
            params.complete();
        }, 1000);
    }
</script>

</body>
</html>