<ul>
    <? foreach($data['supports'] as $id=>$category): ?>
        <li<?= ($data['support_selected']==$category->getAttribute('name')?" class=\"selected\"":"")?>>
        <? __link(	"games/".$category->getAttribute('name'),
        			$category->getInfo('name'),
        			__s('list','list_view_title',$category->getInfo('description'))
        			);?>
        </li>
    <? endforeach; ?>
</ul>