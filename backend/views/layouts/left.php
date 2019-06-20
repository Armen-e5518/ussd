
<aside class="main-sidebar">
    <section class="sidebar">
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                'items' => [
                    ['label' => 'Accounts', 'icon' => 'list', 'url' => ['/accounts']],
                    ['label' => 'Participation', 'icon' => 'list', 'url' => ['/participation']],
                    ['label' => 'Game results', 'icon' => 'list', 'url' => ['/game-results']],
                ],
            ]
        ) ?>
    </section>
</aside>
