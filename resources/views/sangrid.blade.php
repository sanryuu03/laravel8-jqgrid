@extends('layouts.main')

@section('menuContent')
 <p>anda mengunjungi  {{  url('') }}</p>
 <form action="/SangridController/tampilMaster" method="POST">
	<label for="">Global Search</label>
	<input type="search" id="globalSearch" style="width:250px" placeholder="Keyword..."/>
</form>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Laravel 8 - JQGrid | CRUD</a></li>
	</ul>
	<!--  This will be my jqGrid control and pager -->
<table id="tblEmployees"></table>
<div id="pager"></div>
	<div id="tabs-1">
		<table id="list1"></table>
		<div id="plist1"></div>
		<div id="forminput"></div>
		<hr>
		<div id="detailsPlaceholder">
			<table id="jqGridDetails"></table>
			<div id="jqGridDetailsPager"></div>
		</div>
	</div>
</div>
@endsection
