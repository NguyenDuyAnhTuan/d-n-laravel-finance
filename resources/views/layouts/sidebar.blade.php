<!-- side bar -->
<nav>
    <ul>
        <li @if(request()->is('dashboard')) class="active" @endif>
            <a href="{{ route('dashboard') }}">
                <i class="fa-solid fa-chart-pie"></i> Tổng quan
            </a>
        </li>
        <li @if(request()->is('income')) class="active" @endif>
            <a href="{{ route('income.index') }}">
                <i class="fa-solid fa-money-check-dollar"></i> Thu nhập
            </a>
        </li>
        <li @if(request()->is('expense')) class="active" @endif>
            <a href="{{ route('expense.index') }}">
                <i class="fa-solid fa-cart-shopping"></i> Chi tiêu
            </a>
        </li>
        <li @if(request()->is('setting')) class="active" @endif>
            <a href="{{ route('setting.index') }}">
                <i class="fa-solid fa-gear"></i> Cài đặt
            </a>
        </li>
    </ul>
</nav>