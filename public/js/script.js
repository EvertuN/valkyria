function showSection(sectionName, el) {
    const sections = ['dashboard', 'register'];

    // Oculta todas as seções principais
    sections.forEach(section => {
        const element = document.getElementById(section + '-section');
        if (element) element.style.display = 'none';
    });

    // Mostra a seção solicitada
    const selectedSection = document.getElementById(sectionName + '-section');
    if (selectedSection) selectedSection.style.display = 'block';

    // Apenas atualiza os links da SIDEBAR (não tocar nas abas internas do formulário)
    document.querySelectorAll('.sidebar .nav-link').forEach(link => {
        link.classList.remove('active');
    });
    if (el) el.classList.add('active');
}

// On load: abre a seção ativa da sidebar (ou dashboard se não houver)
document.addEventListener('DOMContentLoaded', function() {
    const sidebarActive = document.querySelector('.sidebar .nav-link.active') || document.querySelector('.sidebar .nav-link');
    if (sidebarActive) {
        // usa atributo data-section caso queira simplificar; senão passe a string
        const section = sidebarActive.dataset.section || 'dashboard';
        showSection(section, sidebarActive);
    }
});

// Funções para Itens da Viagem
function addItem() {
    const container = document.getElementById('items-container');
    const newItem = document.createElement('div');
    newItem.className = 'item-row';
    newItem.innerHTML = `
        <div class="row">
            <div class="col-md-5">
                <input type="text" class="form-control" name="item_nome[]" placeholder="Nome do item" required>
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control" name="item_qtd[]" placeholder="Qtd" required>
            </div>
            <div class="col-md-3">
                <select class="form-select" name="item_unidade[]" required>
                    <option value="un">Unidade</option>
                    <option value="kg">Kg</option>
                    <option value="m">Metros</option>
                    <option value="m2">M²</option>
                    <option value="m3">M³</option>
                    <option value="ton">Toneladas</option>
                    <option value="sc">Sacos</option>
                    <option value="cx">Caixa</option>
                    <option value="lt">Litro</option>
                    <option value="bd">Balde</option>
                    <option value="par">Par</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="removeItem(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(newItem);
}

function removeItem(button) {
    const container = document.getElementById('items-container');
    if (container.children.length > 1) {
        button.closest('.item-row').remove();
    }
}

// Funções para Frota
function addFrota() {
    const container = document.getElementById('frota-container');
    const newItem = document.createElement('div');
    newItem.className = 'item-row';
    newItem.innerHTML = `
        <div class="row">
            <div class="col-md-10">
                <input type="text" class="form-control" name="frota[]" 
                       placeholder="Ex: Caminhão Mercedes-Benz Actros 2651, Placa ABC-1234">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="removeFrota(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(newItem);
}

function removeFrota(button) {
    const container = document.getElementById('frota-container');
    if (container.children.length > 1) {
        button.closest('.item-row').remove();
    }
}

// Funções para Implemento
function addImplemento() {
    const container = document.getElementById('implemento-container');
    const newItem = document.createElement('div');
    newItem.className = 'item-row';
    newItem.innerHTML = `
        <div class="row">
            <div class="col-md-10">
                <input type="text" class="form-control" name="implemento[]" 
                       placeholder="Ex: Carreta Basculante, Placa XYZ-5678">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="removeImplemento(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    container.appendChild(newItem);
}

function removeImplemento(button) {
    const container = document.getElementById('implemento-container');
    if (container.children.length > 1) {
        button.closest('.item-row').remove();
    }
}