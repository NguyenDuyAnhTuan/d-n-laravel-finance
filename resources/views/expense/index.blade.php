{{-- resources/views/expense/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Quản lý chi tiêu')

@section('content')
    <div class="chitieu-head">
        <h1 class="header-chitieu">Quản lý chi tiêu</h1>
    </div>
    <hr>
    <div class="container-chitieu">
        <div class="top-bar">
            <div class="pagination">
                <button onclick="prevPage()">&larr;</button>
                <span>Trang <span id="currentPage">1</span>/<span id="totalPages">1</span></span>
                <button onclick="nextPage()">&rarr;</button>
            </div>
            <div class="filter-buttons">
                <button class="active">Tháng này</button>
                <button>Quý này</button>
                <button>Năm nay</button>
                <button>Tùy chỉnh</button>
            </div>
            <div class="search-bar-chitieu">
                <i class="fa-solid fa-search search-icon"></i>
                <input type="text" placeholder="Tìm kiếm mô tả..." id="search-input">
            </div>
            <button class="add-button" onclick="openExpenseForm()">+ Thêm chi tiêu</button>
        </div>
        <table class="table-chitieu">
            <thead class="thead-chitieu">
                <tr>
                    <th>Ngày</th>
                    <th>Hũ</th>
                    <th>Mô tả</th>
                    <th>Số tiền</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="expenseTableBody">
                @foreach($expenses as $expense)
                <tr data-id="{{ $expense->id }}">
                    <td>{{ $expense->date->format('d/m/Y') }}</td>
                    <td class="category">
                        <img src="{{ asset('assets/icon/jars/' . $expense->getJarIcon()) }}" class="category-icon"/>
                        {{ $expense->jar }}
                    </td>
                    <td>{{ $expense->description }}</td>
                    <td>{{ number_format($expense->amount) }} đ</td>
                    <td class="actions">
                        <button onclick="editExpense({{ $expense->id }})">✏️</button>
                        <form action="{{ route('expense.destroy', $expense->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">🗑️</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('modals')
    <!-- Form Thêm/Sửa Khoản Chi Tiêu -->
    <div id="expense-form-container" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeExpenseForm()">&times;</span>
            <h2 id="formTitle">Thêm khoản chi tiêu</h2>
            
            <form id="expenseForm" method="POST">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                
                <label for="expense-date">Ngày:</label>
                <input type="date" id="expense-date" name="date" class="form-control" required>
                
                <label for="expense-jar-select">Hũ:</label>
                <select id="expense-jar-select" name="jar" class="form-control" required>
                    <option value="Thiết Yếu">🏠 Thiết yếu</option>
                    <option value="Tự Do Tài Chính">💰 Tự Do Tài Chính</option>
                    <option value="Giáo Dục">📘 Giáo Dục</option>
                    <option value="Hưởng Thụ">🎉 Hưởng Thụ</option>
                    <option value="Thiện Tâm">🎁 Thiện Tâm</option>
                    <option value="Tiết Kiệm">📋 Tiết Kiệm</option>
                </select>
                
                <label for="expense-amount">Số tiền:</label>
                <input type="number" id="expense-amount" name="amount" class="form-control" placeholder="Nhập số tiền" min="0" required>
                
                <label for="expense-description">Mô tả:</label>
                <input type="text" id="expense-description" name="description" class="form-control" placeholder="Nhập mô tả khoản chi tiêu">
                
                <div class="form-actions">
                    <button type="button" id="cancel-expense" class="btn btn-secondary" onclick="closeExpenseForm()">Hủy</button>
                    <button type="submit" id="save-expense" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Logic JavaScript cho trang chi tiêu
    function openExpenseForm(expenseId = null) {
        const modal = document.getElementById('expense-form-container');
        const formTitle = document.getElementById('formTitle');
        const form = document.getElementById('expenseForm');
        const formMethod = document.getElementById('formMethod');
        
        if (expenseId) {
            formTitle.textContent = 'Sửa khoản chi tiêu';
            formMethod.value = 'PUT';
            form.action = `/expense/${expenseId}`;
            
            // Lấy dữ liệu từ server (hoặc từ bảng)
            const row = document.querySelector(`tr[data-id="${expenseId}"]`);
            if (row) {
                const dateParts = row.cells[0].textContent.split('/');
                const formattedDate = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
                
                document.getElementById('expense-date').value = formattedDate;
                document.getElementById('expense-jar-select').value = row.cells[1].textContent.trim();
                document.getElementById('expense-amount').value = row.cells[3].textContent.replace(/[^\d]/g, '');
                document.getElementById('expense-description').value = row.cells[2].textContent;
            }
        } else {
            formTitle.textContent = 'Thêm khoản chi tiêu';
            formMethod.value = 'POST';
            form.action = "{{ route('expense.store') }}";
            
            // Reset form
            document.getElementById('expense-date').valueAsDate = new Date();
            document.getElementById('expense-jar-select').value = 'Thiết Yếu';
            document.getElementById('expense-amount').value = '';
            document.getElementById('expense-description').value = '';
        }
        
        modal.style.display = 'block';
    }
    
    function closeExpenseForm() {
        document.getElementById('expense-form-container').style.display = 'none';
    }
    
    function editExpense(expenseId) {
        openExpenseForm(expenseId);
    }
    
    // Đóng modal khi click bên ngoài
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('expense-form-container');
        if (event.target === modal) {
            closeExpenseForm();
        }
    });
</script>
@endpush