// Tri de tableau
document.querySelectorAll('.data-table th').forEach((header, index) => {
    if (index > 0) {
      header.style.cursor = 'pointer';
      header.addEventListener('click', () => sortTable(index));
    }
  });
  
  function sortTable(columnIndex) {
    const table = document.querySelector('.data-table');
    const rows = Array.from(table.querySelectorAll('tbody tr'));
    const isAsc = table.dataset.sortColumn === String(columnIndex) && 
                  table.dataset.sortOrder === 'asc';
    
    rows.sort((a, b) => {
      const aVal = a.cells[columnIndex].textContent.trim();
      const bVal = b.cells[columnIndex].textContent.trim();
      
      // Tri numérique pour les montants et quantités
      const aNum = parseFloat(aVal.replace(/[€\s]/g, '').replace(',', '.'));
      const bNum = parseFloat(bVal.replace(/[€\s]/g, '').replace(',', '.'));
      
      if (!isNaN(aNum) && !isNaN(bNum)) {
        return isAsc ? bNum - aNum : aNum - bNum;
      }
      
      return isAsc 
        ? bVal.localeCompare(aVal) 
        : aVal.localeCompare(bVal);
    });
    
    rows.forEach(row => table.querySelector('tbody').appendChild(row));
    
    table.dataset.sortColumn = columnIndex;
    table.dataset.sortOrder = isAsc ? 'desc' : 'asc';
    
    updateSortIndicators(columnIndex);
  }
  
  function updateSortIndicators(columnIndex) {
    document.querySelectorAll('.data-table th').forEach((header, index) => {
      header.textContent = header.textContent.replace(/\s*[↑↓]/g, '');
      if (index === columnIndex) {
        const order = document.querySelector('.data-table').dataset.sortOrder;
        header.textContent += order === 'asc' ? ' ↑' : ' ↓';
      }
    });
  }
  
  // Recherche/Filtre
  function filterTable(searchTerm) {
    const rows = document.querySelectorAll('.data-table tbody tr');
    const term = searchTerm.toLowerCase();
    
    rows.forEach(row => {
      const text = row.textContent.toLowerCase();
      row.style.display = text.includes(term) ? '' : 'none';
    });
  }
  
  // Imprimer
  function printTable() {
    window.print();
  }