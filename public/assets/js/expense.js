//1. lấy các phần tử DOM 
const addExpenseBtn = document.querySelector('.add-button'); 
const expenseModal = document.getElementById('expense-form-container');
const closeBtn = expenseModal.querySelector('.close');
const cancelBtn = document.getElementById('cancel-expense');

//2. Function để mở model thêm chi tiêu
function openExpenseModal() {
    // Reset form fields
    document.getElementById('expense-date').valueAsDate = new Date(); // lấy date là ngày hnay
    document.getElementById('expense-jar-select').value = 'jar-thietyeu'; // chọn mặc định là thiết yếu
    document.getElementById('expense-amount').value = ''; // amount thêm vào để trống
    document.getElementById('expense-description').value = ''; // description để trống
    
    // Show modal
    expenseModal.style.display = 'block';
    setTimeout(() => {
        expenseModal.classList.add('show');
    }, 10);
}

//3. Function để đóng
// Hàm đóng form thêm chi tiêu
function closeExpenseForm() {
    const overlay = document.getElementById('expenseFormOverlay');
    overlay.classList.remove('show');
    setTimeout(() => {
      overlay.style.display = 'none';
      // Reset form
      document.getElementById('expense-date').value = new Date().toISOString().split('T')[0];
      document.getElementById('expense-jar').value = '';
      document.getElementById('expense-amount').value = '';
      document.getElementById('expense-description').value = '';
    }, 300);
  }

//4. sử dụng các hàm bằng event listeners
// Event listeners
addExpenseBtn.addEventListener('click', openExpenseModal);
closeBtn.addEventListener('click', closeExpenseModal);
cancelBtn.addEventListener('click', closeExpenseModal);


// Close modal when clicking outside
window.addEventListener('click', (event) => {
    if (event.target === expenseModal) {
        closeExpenseModal();
    }
});

// Hàm lưu chi tiêu
function saveExpense() {
    const date = document.getElementById('expense-date').value;
    const jar = document.getElementById('expense-jar').value;
    const amount = document.getElementById('expense-amount').value;
    const description = document.getElementById('expense-description').value;
  }
  // Biến lưu trữ dữ liệu chi tiêu
let expenses = [];
let editingExpenseId = null;
let currentPage = 1;
const itemsPerPage = 5;

// Hàm định dạng tiền tệ
function formatCurrency(amount) {
  return new Intl.NumberFormat('vi-VN').format(amount) + ' đ';
}

// Hàm hiển thị chi tiêu trong bảng
function renderExpenses() {
  const tbody = document.getElementById('expenseTableBody');
  tbody.innerHTML = '';
  const startIndex = (currentPage - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  const paginatedExpenses = expenses.slice(startIndex, endIndex);
  
  paginatedExpenses.forEach(expense => {
    const row = document.createElement('tr');
    row.dataset.id = expense.id;
    row.innerHTML = `
      <td>${expense.date}</td>
      <td class="category">
        <img src="assets/icon/jars/${getJarIcon(expense.jar)}" class="category-icon"/>
        ${expense.jar}
      </td>
      <td>${expense.description}</td>
      <td>${formatCurrency(expense.amount)}</td>
      <td class="actions">
        <button onclick="editExpense(${expense.id})">✏️</button>
        <button onclick="deleteExpense(${expense.id})">🗑️</button>
      </td>
    `;
    tbody.appendChild(row);
  });
  
  // Cập nhật phân trang
  document.getElementById('currentPage').textContent = currentPage;
  const totalPages = Math.ceil(expenses.length / itemsPerPage);
  document.getElementById('totalPages').textContent = totalPages;
}

// Hàm lấy biểu tượng hũ
function getJarIcon(jarName) {
  const jarIcons = {
    'Thiết Yếu': 'icons8-home-48.png',
    'Tự Do Tài Chính': 'icons8-money-bag-48.png',
    'Giáo Dục': 'icons8-books-50.png',
    'Hưởng Thụ': 'icons8-pub-50.png',
    'Thiện Tâm': 'icons8-gift-50.png',
    'Tiết Kiệm': 'icons8-saving-money-64.png'
  };
  return jarIcons[jarName] || 'icons8-money-bag-48.png';
}

// Sửa hàm đóng modal
function closeExpenseForm() {
  const modal = document.getElementById('expense-form-container');
  hideModal(modal);
  editingExpenseId = null;
}

// Hàm hiển thị modal (giống trong income.js)
function showModal(modal) {
  modal.style.display = 'block';
  modal.offsetHeight; // Force reflow
  modal.classList.add('show');
}

// Hàm ẩn modal (giống trong income.js)
function hideModal(modal) {
  modal.classList.remove('show');
  setTimeout(() => {
    modal.style.display = 'none';
  }, 300);
}

// Gắn sự kiện khi DOM tải xong
document.addEventListener('DOMContentLoaded', () => {
  // ... code hiện tại ...

  // Gắn sự kiện cho nút Lưu trong modal
  document.getElementById('save-expense').addEventListener('click', saveExpense);
  
  // Gắn sự kiện cho nút Hủy
  document.getElementById('cancel-expense').addEventListener('click', closeExpenseForm);
  
  // Gắn sự kiện cho nút đóng (x)
  document.querySelector('#expense-form-container .close').addEventListener('click', closeExpenseForm);
  
  // Đóng modal khi click bên ngoài
  window.addEventListener('click', (event) => {
    const modal = document.getElementById('expense-form-container');
    if (event.target === modal) {
      closeExpenseForm();
    }
  });
});
// Hàm mở form thêm/sửa chi tiêu
function openExpenseForm(expenseId = null) {
  const modal = document.getElementById('expense-form-container');
  const formTitle = document.getElementById('formTitle');
  
  if (expenseId) {
    formTitle.textContent = 'Sửa khoản chi tiêu';
    editingExpenseId = expenseId;
    
    // Tìm chi tiêu cần sửa
    const expense = expenses.find(e => e.id === expenseId);
    
    // Điền dữ liệu vào form
    document.getElementById('expense-date').value = expense.date;
    document.getElementById('expense-jar-select').value = expense.jar;
    document.getElementById('expense-amount').value = expense.amount;
    document.getElementById('expense-description').value = expense.description;
  } else {
    formTitle.textContent = 'Thêm khoản chi tiêu';
    editingExpenseId = null;
    
    // Đặt giá trị mặc định
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('expense-date').value = today;
    document.getElementById('expense-jar-select').value = 'Thiết Yếu';
    document.getElementById('expense-amount').value = '';
    document.getElementById('expense-description').value = '';
  }
  
  showModal(modal);
}

// Hàm lưu chi tiêu
function saveExpense() {
  const date = document.getElementById('expense-date').value;
  const jar = document.getElementById('expense-jar-select').value;
  const amount = parseFloat(document.getElementById('expense-amount').value);
  const description = document.getElementById('expense-description').value;
  
  if (!date || !jar || isNaN(amount) || !description) {
    alert('Vui lòng điền đầy đủ thông tin');
    return;
  }
  
  if (editingExpenseId) {
    // Cập nhật chi tiêu hiện có
    const index = expenses.findIndex(e => e.id === editingExpenseId);
    if (index !== -1) {
      expenses[index] = {
        ...expenses[index],
        date,
        jar,
        amount,
        description
      };
    }
  } else {
    // Thêm chi tiêu mới
    const newId = expenses.length > 0 ? Math.max(...expenses.map(e => e.id)) + 1 : 1;
    expenses.push({
      id: newId,
      date,
      jar,
      amount,
      description
    });
  }
  
  // Render lại bảng và đóng form
  renderExpenses();
  closeExpenseForm();
}
// Hàm sửa chi tiêu
function editExpense(expenseId) {
  openExpenseForm(expenseId);
}

// Hàm xóa chi tiêu
function deleteExpense(expenseId) {
  if (confirm('Bạn có chắc muốn xóa mục chi tiêu này không?')) {
    expenses = expenses.filter(expense => expense.id !== expenseId);
    renderExpenses();
  }
}

// Hàm chuyển trang trước
function prevPage() {
  if (currentPage > 1) {
    currentPage--;
    renderExpenses();
  }
}

// Hàm chuyển trang sau
function nextPage() {
  const totalPages = Math.ceil(expenses.length / itemsPerPage);
  if (currentPage < totalPages) {
    currentPage++;
    renderExpenses();
  }
}

// Khởi tạo dữ liệu và gắn sự kiện
document.addEventListener('DOMContentLoaded', () => {
  // Dữ liệu mẫu khởi tạo
  expenses = [
    {id: 1, date: '2025-04-10', jar: 'Giáo Dục', description: 'Mua sách lập trình', amount: 250000},
    {id: 2, date: '2025-04-09', jar: 'Thiết Yếu', description: 'Tiền điện nước', amount: 350000},
    {id: 3, date: '2025-04-08', jar: 'Thiện Tâm', description: 'Ủng hộ từ thiện', amount: 500000}
  ];
  renderExpenses();

  // Gắn sự kiện
  document.querySelector('.add-button').addEventListener('click', () => openExpenseForm());
  document.querySelector('#expense-form-container .close').addEventListener('click', () => closeExpenseForm());
  document.getElementById('cancel-expense').addEventListener('click', () => closeExpenseForm());
  document.getElementById('save-expense').addEventListener('click', () => saveExpense());
  window.addEventListener('click', (event) => {
    const modal = document.getElementById('expense-form-container');
    if (event.target === modal) {
      closeExpenseForm();
    }
  });
});


  // Đóng modal khi click ra ngoài
  window.addEventListener('click', (event) => {
    const modal = document.getElementById('expense-form-container');
    if (event.target === modal) {
      closeExpenseForm();
    }
  });
  function saveToStorage() {
  localStorage.setItem('expenses', JSON.stringify(expenses));
}

function loadFromStorage() {
  const stored = localStorage.getItem('expenses');
  expenses = stored ? JSON.parse(stored) : [];
}
