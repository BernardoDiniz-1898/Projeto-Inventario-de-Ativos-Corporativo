import Alpine from 'alpinejs'

window.Alpine = Alpine

document.addEventListener('alpine:init', () => {
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
})

Alpine.start()
