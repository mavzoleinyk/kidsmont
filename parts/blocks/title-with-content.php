<?php 

$list = get_sub_field('list');

?>

<div class="padding-wrap">
    <div class="container-sm">
        <div class="main-table main-table--second">

            <?php foreach ($list as $li):

                $option = $li['option'];

                ?>

                <div class="main-table__tr">
                    <div class="main-table__td">
                        <h4 class="main-table__title"><?= $li['title'];?></h4>
                    </div>
                    <div class="main-table__td text-content">

                        <?php if($option == 'Text'):?>

                            <?= $li['text'];?>

                        <?php elseif($option == 'Video'):

                            $v = $li['video'];?>

                            <div class="video-wrap">
                                <a href="<?= $v['video']['url'];?>" data-fancybox class="video not-hover">
                                    <div class="video__poster ibg">
                                        <img src="<?= $v['placeholder']['url'];?>" alt="<?= $v['placeholder']['alt'];?>">
                                    </div>
                                    <div class="video__btn">
                                        <div class="btn">
                                            <div class="btn__text-decor">
                                                <img class="img-svg" src="<?= get_template_directory_uri();?>/img/photo/play-text.svg" alt="">
                                            </div>
                                            <div class="btn__text">Play</div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        <?php elseif($option == 'Advantages'):

                            $advs = $li['advantages'];?>

                            <ul class="list-col-2">

                                <?php foreach ($advs as $adv):?>
                                    <li>
                                        <h5><?= $adv['title'];?></h5>
                                        <p><?= $adv['description'];?></p>
                                    </li>
                                <?php endforeach;?>
                            </ul>

                        <?php elseif($option == 'Tables'):

                            $tables = $li['tables'];

                            foreach ($tables as $tab):?>

                                <div class="main-table__td-row">
                                    <h6><?= $tab['title'];?></h6>

                                    <?php if(!empty($tab['list'])):?>

                                        <table class="info-table">

                                            <?php foreach ($tab['list'] as $li):?>
                                            
                                                <tr>
                                                    <td><?= $li['label'];?></td>
                                                    <td><?= $li['text'];?></td>
                                                </tr>

                                            <?php endforeach;?>

                                        </table>

                                    <?php endif;?>

                                </div>

                            <?php endforeach;        

                        endif;?>

                    </div>
                </div>

            <?php endforeach;?>

        </div>
    </div>
</div>