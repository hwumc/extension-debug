{extends file="base.tpl"}
{block name="body"}
<form method="post">
	<table class="table table-condensed table-bordered">
		<thead>
			<tr>
				<th>Date</th>
				<th>Exception</th>
				<th>Message</th>
				<th>Session</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			{foreach from="$exceptionlist" item="e" key="f" name="error" }
				<tr>
					<th rowspan="2">{$e.date}</th>
					<td>{$e.type}</td>
					<td>{$e.exception->getMessage()}</td>
					<td>{$e.session}</td>
					<td><button name="{$f}" class="btn btn-danger btn-small">Delete</button></td>
				</tr>
				<tr>
					<td colspan="4" style="padding: 0;">
						<div class="accordion" id="accordion{$smarty.foreach.error.index}" style="margin-bottom: 0;">
							<div class="accordion-group" style="margin-bottom: 0; border: none;">
								<div class="accordion-heading">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion{$smarty.foreach.error.index}" href="#collapseOne">
										Show stack trace
									</a>
								</div>
								<div id="collapseOne" class="accordion-body collapse">
									<div class="accordion-inner">
										<pre>{$e.exception}</pre>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
			{/foreach}
		</tbody>
	</table>
</form>
{/block}