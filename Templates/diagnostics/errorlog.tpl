{extends file="base.tpl"}
{block name="body"}
<form method="post">
	<table class="table table-condensed table-bordered">
		<thead>
			<tr>
				<th>Date</th>
				<th>Session</th>
				<th>Exception</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			{foreach from="$exceptionlist" item="e" key="f" }
				<tr>
					<th rowspan="2">{$e.date}</th>
					<td>{$e.session}</td>
					<td>{$e.type}</td>
					<td><button name="{$f}" class="btn btn-danger btn-small">Delete</button></td>
				</tr>
				<tr>
					<td colspan="3"><pre>{$e.exception}</pre></td>
				</tr>
			{/foreach}
		</tbody>
	</table>
</form>
{/block}