<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php foreach ($items as $item):?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="heading<?=$item->id?>">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$item->id?>" aria-expanded="true" aria-controls="collapse<?=$item->id?>">
                        <h4><?=$item->id?></h4><span class="text-danger">Cообщение модератора: <?=$item->descriptions?></span>
                    </a>
                </h4>
            </div>
            <div id="collapse<?=$item->id?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?=$item->id?>">
                <div class="panel-body">
                    <h4> тут будет раскрыт весь товар для редактирования/удаления..</h4>
                </div>
            </div>
        </div>
    <?php endforeach;?>
</div>
