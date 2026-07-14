import Alpine from 'alpinejs'

window.Alpine = Alpine

document.addEventListener('alpine:init', () => {
    // Toast system (Alpine store for programmatic use)
    Alpine.store('toasts', {
        items: [],
        add(message, type = 'success') {
            const id = Date.now()
            this.items.push({ id, message, type, show: true })
            setTimeout(() => this.remove(id), 4000)
        },
        remove(id) {
            const t = this.items.find(t => t.id === id)
            if (t) t.show = false
            setTimeout(() => {
                this.items = this.items.filter(t => t.id !== id)
            }, 300)
        }
    })

    // Toast component for layout (x-data="toast()")
    Alpine.data('toast', () => ({
        toasts: [],
        add(detail) {
            const t = { ...detail, id: Date.now(), show: true }
            this.toasts.push(t)
            setTimeout(() => this.remove(t.id), 4000)
        },
        remove(id) {
            const t = this.toasts.find(t => t.id === id)
            if (t) t.show = false
            setTimeout(() => {
                this.toasts = this.toasts.filter(t => t.id !== id)
            }, 300)
        }
    }))

    // Global toast dispatch (used by settings page JS)
    window.showToast = function(message, type = 'success') {
        window.dispatchEvent(new CustomEvent('toast', { detail: { message, type } }))
    }

    // Searchable select for employees
    Alpine.data('searchableSelect', () => ({
        search: '',
        openDropdown: false,
        selectedId: null,
        items: [],
        filtered: [],

        init() {
            this.items = window._employeesData || []
            this.filtered = this.items
            this.selectedId = window._selectedEmployeeId || null
            if (this.selectedId) {
                const item = this.items.find(i => i.id == this.selectedId)
                if (item) this.search = item.nome
            }
        },

        open() {
            this.filtered = this.items
            this.openDropdown = true
        },

        close() {
            this.openDropdown = false
        },

        filter() {
            const term = this.search.toLowerCase()
            this.filtered = this.items.filter(i =>
                i.nome.toLowerCase().includes(term) ||
                (i.departamento && i.departamento.toLowerCase().includes(term))
            )
            this.openDropdown = true
        },

        select(item) {
            this.selectedId = item.id
            this.search = item.nome
            this.openDropdown = false
        },

        clear() {
            this.selectedId = null
            this.search = ''
            this.filtered = this.items
        },

        initials(nome) {
            return nome.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase()
        }
    }))

    // Confirm delete dialog
    Alpine.data('confirmDelete', () => ({
        show: false,
        action: null,
        open(action) {
            this.action = action
            this.show = true
        },
        confirm() {
            if (this.action) this.action()
            this.show = false
        },
        cancel() {
            this.show = false
        }
    }))
})

Alpine.start()
