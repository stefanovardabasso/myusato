@inject('menu', 'App\Libraries\Menu\Menu')
<h3 class="page-title"><i class="fa {{ $menu->getActiveIcon() }}"></i> {{ $title }}</h3>
