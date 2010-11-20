<? if (!empty($view)): ?>
	<?= $html->link(
		$html->image('icons/actions/search.png', array('alt' => 'View', 'title' => 'View')),
		array('action' => 'view', $id),
		array('escape' => false, 'id' => 'view-'.$id, 'class' => 'button view')
	); ?>
	<? if ($this->params['controller'] == 'orders'): ?>
		<script type="text/javascript">$(function() {$("a.view").nyroModal({blocker: "#content",ltr: false,width: 600});});</script>
	<? endif; ?>
<? endif; ?>
<? if (!empty($edit)): ?>
	<?= $html->link(
		$html->image('icons/actions/edit.png', array('alt' => 'Edit', 'title' => 'Edit')),
		array('action' => 'edit', $id),
		array('escape' => false, 'id' => 'edit-'.$id, 'class' => 'button edit')
	); ?>
	<script type="text/javascript">$(function() {$("a.edit").nyroModal({blocker: "#content",ltr: false,width: 600});});</script>
<? endif; ?>
<? if (!empty($delete)): ?>
	<?= $html->link(
		$html->image('icons/actions/delete.png', array('alt' => 'Delete', 'title' => 'Delete')),
		array('action' => 'delete', $id),
		array('escape' => false, 'id' => 'delete-'.$id, 'class' => 'button delete')
	); ?>
<? endif; ?>