@php
	$edit_user = \App\Models\User::find($fields['user_id']['value']);
@endphp
{{-- <p>{{ $user->id }}</p>
<p>{{ $edit_user }}</p> --}}
{{-- @dd(get_defined_vars()) --}}

	<table class="table_history">
		<tr>
			<td>Дата</td>
			<td>Действие</td>
		</tr>
		@if(count($edit_user->history()->get()))
			@foreach($edit_user->history()->get() as $item)
				<tr>
					<td>
						{{ $item->created_at }}
					</td>
					<td>
						@if($item->action == 'subscribed')
							Оформил подписку 
						@elseif($item->action == 'unsubscribed')
							Отменил подписку
						@elseif($item->action == 'renewed')
							Продлил подписку
						@elseif($item->action == 'unrenew')
							Подписка не продлена
						@endif
					</td>
				</tr>
			@endforeach
		@else
			<tr>
				<td colspan="2">
					Данных не найдено
				</td>
			</tr>
		@endif

	</table>


<style type="text/css">
	.table_history tr td{
		padding: 10px;
	}
</style> 