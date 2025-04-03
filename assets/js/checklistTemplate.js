document.addEventListener('turbo:load', function() {
    // Initialisation de Sortable.js
    const sortableList = document.getElementById('sortable-items');
    const sortable = new Sortable(sortableList, {
        animation: 150,
        handle: '.drag-handle',
        ghostClass: 'bg-blue-100',
        onEnd: function() {
            updatePositions();
        }
    });
    
    // Fonction pour ajouter un nouvel élément
    function addItemForm($collectionHolder, $newLinkDiv) {
        // Récupère l'élément prototype
        const prototype = $collectionHolder.dataset.prototype;
        
        // Trouve l'index actuel
        const index = $collectionHolder.querySelectorAll('.item-row').length;
        
        // Remplace __name__ par l'index dans le prototype
        const newForm = prototype.replace(/__name__/g, index);
        
        // Crée un nouvel élément div pour le formulaire
        const $newFormDiv = document.createElement('div');
        $newFormDiv.classList.add('item-row', 'bg-white', 'p-4', 'rounded-md', 'shadow-sm', 'mb-3', 'flex', 'items-center');
        
        // Prépare le contenu HTML avec la poignée de drag & drop
        $newFormDiv.innerHTML = `
            <div class="drag-handle cursor-move mr-3 text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                </svg>
            </div>
            <div class="item-content flex-1">
                ${newForm}
            </div>
            <button type="button" class="remove-item ml-4 px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        `;
        
        // Ajoute le formulaire au conteneur
        $collectionHolder.appendChild($newFormDiv);
        
        // Récupère l'élément div principal généré par le prototype
        const mainFormDiv = $newFormDiv.querySelector('.item-content > div');
        if (mainFormDiv) {
            // Structure l'affichage des éléments
            const wrapperDiv = document.createElement('div');
            wrapperDiv.classList.add('flex', 'flex-wrap', 'gap-4', 'items-center');
            
            // Find all immediate child divs (which contain label + input pairs)
            const childDivs = Array.from(mainFormDiv.children).filter(el => el.tagName === 'DIV');
            
            // Find the hidden position input (which is a direct child, not in a div)
            const positionInput = Array.from(mainFormDiv.children).find(el => 
                el.tagName === 'INPUT' && el.type === 'hidden');
            
            // Process label div (first div)
            if (childDivs.length > 0) {
                const labelDiv = childDivs[0];
                labelDiv.classList.add('w-full', 'md:w-3/5');
                
                const labelElement = labelDiv.querySelector('label');
                if (labelElement) {
                    labelElement.classList.add('block', 'text-gray-700', 'text-sm', 'font-bold', 'mb-1');
                }
                
                const textInput = labelDiv.querySelector('input[type="text"]');
                if (textInput) {
                    textInput.classList.add('shadow', 'appearance-none', 'border', 'rounded', 'w-full', 'py-2', 'px-3', 'text-gray-700', 'leading-tight', 'focus:outline-none', 'focus:shadow-outline');
                }
                
                // Move to the wrapper
                wrapperDiv.appendChild(labelDiv);
            }
            
            // Process checkbox div (second div)
            if (childDivs.length > 1) {
                const checkboxDiv = childDivs[1];
                checkboxDiv.classList.add('flex', 'items-center', 'gap-2');
                
                const checkbox = checkboxDiv.querySelector('input[type="checkbox"]');
                if (checkbox) {
                    checkbox.classList.add('m-2', 'h-4', 'w-4', 'text-blue-600', 'focus:ring-blue-500', 'border-gray-300', 'rounded');
                }
                
                const checkboxLabel = checkboxDiv.querySelector('label');
                if (checkboxLabel) {
                    checkboxLabel.classList.add('text-gray-700', 'text-sm');
                }
                
                // Move to the wrapper
                wrapperDiv.appendChild(checkboxDiv);
            }
            
            // Clear the main div and add our structured wrapper
            mainFormDiv.innerHTML = '';
            mainFormDiv.appendChild(wrapperDiv);
            
            // Add back the position input
            if (positionInput) {
                positionInput.classList.add('item-position', 'hidden');
                positionInput.value = index;
                mainFormDiv.appendChild(positionInput);
            }
        }
        
        // Attache l'événement de suppression au nouveau bouton
        $newFormDiv.querySelector('.remove-item').addEventListener('click', function() {
            $newFormDiv.remove();
            updatePositions();
        });
    }
    
    // Fonction pour mettre à jour les positions des éléments
    function updatePositions() {
        const items = document.querySelectorAll('.item-row');
        items.forEach((item, index) => {
            const positionInput = item.querySelector('.item-position');
            if (positionInput) {
                positionInput.value = index;
            }
        });
    }
    
    // Récupère le conteneur d'éléments
    const $collectionHolder = document.querySelector('.items');
    
    // Ajoute un nouvel élément quand on clique sur le bouton
    const $addItemButton = document.querySelector('.add-item');
    $addItemButton.addEventListener('click', function() {
        addItemForm($collectionHolder, $addItemButton);
    });
    
    // Attache des écouteurs d'événements aux boutons de suppression existants
    document.querySelectorAll('.remove-item').forEach(function(button) {
        button.addEventListener('click', function() {
            button.closest('.item-row').remove();
            updatePositions();
        });
    });
    
    // Si aucun élément n'existe, en ajouter un par défaut
    if ($collectionHolder.querySelectorAll('.item-row').length === 0) {
        addItemForm($collectionHolder, $addItemButton);
    }
});