class DocumentPreview {
    constructor() {
        this.modal = null;
        this.modalContent = null;
        this.initModal();
        this.bindEvents();
    }

    initModal() {
        // Crear el modal si no existe
        if (!document.getElementById('previewModal')) {
            const modalHTML = `
                <div id="previewModal" class="preview-modal">
                    <div class="preview-modal-content">
                        <div class="preview-modal-header">
                            <h3 id="previewTitle">Vista Previa del Documento</h3>
                            <span class="preview-close">&times;</span>
                        </div>
                        <div class="preview-modal-body" id="previewBody">
                            <div class="preview-loading">
                                <div class="spinner"></div>
                                <p>Cargando documento...</p>
                            </div>
                        </div>
                        <div class="preview-modal-footer">
                            <button class="btn btn-secondary preview-close-btn">Cerrar</button>
                            <a id="previewDownload" href="#" download class="btn btn-primary" style="display:none;">
                                <i class="fas fa-download"></i> Descargar
                            </a>
                        </div>
                    </div>
                </div>
            `;
            document.body.insertAdjacentHTML('beforeend', modalHTML);
        }

        this.modal = document.getElementById('previewModal');
        this.modalContent = document.getElementById('previewBody');
    }

    bindEvents() {
        // Cerrar modal
        document.querySelectorAll('.preview-close, .preview-close-btn').forEach(element => {
            element.addEventListener('click', () => this.closeModal());
        });

        // Cerrar al hacer clic fuera del modal
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) {
                this.closeModal();
            }
        });

        // Escape key para cerrar
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal.style.display === 'flex') {
                this.closeModal();
            }
        });
    }

    showModal(title = 'Vista Previa del Documento') {
        document.getElementById('previewTitle').textContent = title;
        this.modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    closeModal() {
        this.modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        this.modalContent.innerHTML = `
            <div class="preview-loading">
                <div class="spinner"></div>
                <p>Cargando documento...</p>
            </div>
        `;
        document.getElementById('previewDownload').style.display = 'none';
    }

    previewFile(file, inputElement = null) {
        const fileType = file.type || '';
        const fileName = file.name || 'Documento';

        // Validar tamaño (5MB máximo)
        if (file.size > 5 * 1024 * 1024) {
            alert('El archivo excede el tamaño máximo permitido de 5MB');
            if (inputElement) inputElement.value = '';
            return;
        }

        this.showModal(`Vista Previa: ${fileName}`);

        // Crear URL del archivo
        const fileURL = URL.createObjectURL(file);

        // Configurar botón de descarga
        const downloadBtn = document.getElementById('previewDownload');
        downloadBtn.href = fileURL;
        downloadBtn.download = fileName;
        downloadBtn.style.display = 'inline-block';

        // Determinar el tipo de preview según el tipo de archivo
        if (fileType.startsWith('image/')) {
            this.previewImage(fileURL, fileName);
        } else if (fileType === 'application/pdf') {
            this.previewPDF(fileURL);
        } else if (fileType.includes('wordprocessingml') ||
                   fileType.includes('msword') ||
                   fileName.endsWith('.doc') ||
                   fileName.endsWith('.docx')) {
            this.previewWord(file, fileURL, fileName);
        } else {
            this.showUnsupportedMessage(fileName);
        }
    }

    previewImage(url, fileName) {
        this.modalContent.innerHTML = `
            <div class="preview-image-container">
                <img src="${url}" alt="${fileName}" class="preview-image">
            </div>
        `;
    }

    previewPDF(url) {
        this.modalContent.innerHTML = `
            <iframe src="${url}" class="preview-iframe" type="application/pdf">
                <p>Tu navegador no puede mostrar PDFs.
                   <a href="${url}" download>Descargar PDF</a>
                </p>
            </iframe>
        `;
    }

    previewWord(file, url, fileName) {
        // Opción 1: Usar Google Docs Viewer (requiere que el archivo esté en línea)
        // Para archivos locales, mostraremos información del archivo

        const fileSize = (file.size / 1024).toFixed(2); // KB
        const lastModified = new Date(file.lastModified).toLocaleDateString('es-PE');

        this.modalContent.innerHTML = `
            <div class="preview-word-container">
                <div class="file-info-card">
                    <div class="file-icon">
                        <i class="fas fa-file-word"></i>
                    </div>
                    <div class="file-details">
                        <h4>${fileName}</h4>
                        <p><strong>Tipo:</strong> Documento de Word</p>
                        <p><strong>Tamaño:</strong> ${fileSize} KB</p>
                        <p><strong>Última modificación:</strong> ${lastModified}</p>
                    </div>
                    <div class="file-actions">
                        <p class="info-text">
                            <i class="fas fa-info-circle"></i>
                            Vista previa no disponible para documentos Word.
                            El archivo se cargará correctamente al guardar el formulario.
                        </p>
                        <button class="btn btn-primary" onclick="document.getElementById('previewDownload').click()">
                            <i class="fas fa-download"></i> Descargar para ver
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    previewExistingFile(url, fileName, fileType) {
        this.showModal(`Vista Previa: ${fileName}`);

        // Configurar botón de descarga
        const downloadBtn = document.getElementById('previewDownload');
        downloadBtn.href = url;
        downloadBtn.download = fileName;
        downloadBtn.style.display = 'inline-block';

        if (fileType === 'image') {
            this.previewImage(url, fileName);
        } else if (fileType === 'pdf') {
            this.previewPDF(url);
        } else if (fileType === 'word') {
            // Para archivos Word ya subidos, intentar usar Google Docs Viewer
            const googleViewerUrl = `https://docs.google.com/viewer?url=${encodeURIComponent(url)}&embedded=true`;
            this.modalContent.innerHTML = `
                <iframe src="${googleViewerUrl}" class="preview-iframe">
                    <p>No se puede mostrar el documento.
                       <a href="${url}" download>Descargar documento</a>
                    </p>
                </iframe>
            `;
        }
    }

    showUnsupportedMessage(fileName) {
        this.modalContent.innerHTML = `
            <div class="preview-unsupported">
                <i class="fas fa-file"></i>
                <h4>Formato no soportado para vista previa</h4>
                <p>El archivo "${fileName}" se cargará correctamente, pero no se puede previsualizar.</p>
                <button class="btn btn-primary" onclick="document.getElementById('previewDownload').click()">
                    <i class="fas fa-download"></i> Descargar archivo
                </button>
            </div>
        `;
    }
}

// Inicializar cuando el DOM esté listo
let documentPreview;
document.addEventListener('DOMContentLoaded', function() {
    documentPreview = new DocumentPreview();
});
