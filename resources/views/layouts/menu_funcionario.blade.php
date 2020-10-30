<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
    <li class="nav-header">ADMINISTRAÇÃO</li>
    <li class="nav-item">
        <a class="nav-link" href="/clientes">
            <i class="fas fa-fw fa-user"></i>
            <span>
                Clientes
            </span>

        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/produtos">
            <i class="fas fa-archive"></i>
            <span>
                Produtos
            </span>

        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/pedidos">
            <i class="fas fa-align-justify"></i>
            <span>
                Pedidos
            </span>

        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/pagamentos">
            <i class="fas fa-money-bill"></i>
            <span>
                Pagamentos
            </span>

        </a>
    </li>
    <novopedido-component id_usuario="{{ Auth::user()->id }}"></novopedido-component>
</ul>