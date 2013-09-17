{extends file="base.tpl"}
{block name="pagedescription"}{/block}
{block name="pageheader"}
	<div class="page-header">
	  <h1>{$reporttitle}</h1>
	</div>
{/block}
{block name="sidebar"}{/block}
{block name="rowinit"}<div class="span12">{/block}
{block name="body"}

<ul class="breadcrumb">
  <li><a href="{$cScriptPath}">Home</a> <span class="divider">/</span></li>
  <li><a href="{$cScriptPath}/DatabaseReports">{message name="page-databasereports"}</a> <span class="divider">/</span></li>
  <li class="active">{message name="DatabaseReports-button-execute"}</li>
</ul>

<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			{foreach from="$columns" item="col"}
				<th>{$col.name}</th>
			{/foreach}
		</tr>
	</thead>
	<tbody>
		{foreach from="$resultset" item="row"}
			<tr>
				{foreach from="$row" item="cell"}
					<td>
						{$cell}
					</td>
				{/foreach}
			</tr>	
		{/foreach}	
	</tbody>
</table>
{/block}