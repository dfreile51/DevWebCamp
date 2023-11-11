(function () {
    const tagsInput = document.querySelector("#tags_input");

    // Si existe el input...
    if (tagsInput) {
        const tagsDiv = document.querySelector("#tags");
        const tagsInputHidden = document.querySelector("[name='tags']");

        let tags = [];

        // Recuperar del input oculto
        if (tagsInputHidden.value !== "") {
            tags = tagsInputHidden.value.split(",");
            mostrarTags();
        }

        // Escuchar los cambios en el input
        tagsInput.addEventListener("keypress", guardarTag);

        function guardarTag(e) {
            // Si se presiono la coma...
            if (e.keyCode === 44) {
                e.preventDefault();

                if (e.target.value.trim() === "" || e.target.value.length < 1) {
                    return;
                }

                tags = [...tags, e.target.value.trim()];

                tagsInput.value = "";

                mostrarTags();
            }
        }

        function mostrarTags() {
            limpiarTags();

            tags.forEach(tag => {
                const etiqueta = document.createElement("LI");
                etiqueta.classList.add("formulario__tag");
                etiqueta.textContent = tag;
                etiqueta.ondblclick = eliminarTag;
                tagsDiv.appendChild(etiqueta);
            });

            actualizarInputHidden();
        }

        function actualizarInputHidden() {
            tagsInputHidden.value = tags.toString();
        }

        function eliminarTag(e) {
            e.target.remove();

            tags = tags.filter(tag => tag !== e.target.textContent);

            actualizarInputHidden();
        }

        function limpiarTags() {
            while (tagsDiv.firstChild) {
                tagsDiv.removeChild(tagsDiv.firstChild);
            }
        }
    }
})();
