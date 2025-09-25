document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.form.submit();
            }
        });
    }
    
    highlightSearchTerm();
    
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
        });
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
});

function highlightSearchTerm() {
    const urlParams = new URLSearchParams(window.location.search);
    const searchTerm = urlParams.get('search');
    
    if (searchTerm && searchTerm.length > 0) {
        const tableBody = document.querySelector('tbody');
        if (tableBody) {
            const regex = new RegExp(`(${searchTerm})`, 'gi');
            const walker = document.createTreeWalker(
                tableBody,
                NodeFilter.SHOW_TEXT,
                null,
                false
            );
            
            const textNodes = [];
            while (walker.nextNode()) {
                textNodes.push(walker.currentNode);
            }
            
            textNodes.forEach(node => {
                const matches = node.textContent.match(regex);
                if (matches) {
                    const span = document.createElement('span');
                    span.innerHTML = node.textContent.replace(regex, '<span class="search-highlight">$1</span>');
                    node.parentNode.replaceChild(span, node);
                }
            });
        }
    }
}