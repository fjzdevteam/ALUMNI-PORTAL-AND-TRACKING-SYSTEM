window.employmentModal = function (initialStatus) {
    return {
        showUnemployedModal: false,
        employmentStatus: initialStatus,

        async saveStatus() {
            const selected = document.getElementById('employment_status').value.toLowerCase();
            this.employmentStatus = selected;

            if (selected === 'unemployed') {
                this.showUnemployedModal = true;
            } else {
                await this.submitForm();
            }
        },

        async submitForm() {
            const form = this.$refs.statusForm;
            const formData = new FormData(form);

            try {
                const response = await fetch("{{ route('alumni.update.employment.status') }}", {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': formData.get('_token') },
                    body: formData,
                });

                if (response.ok) {
                    window.location.reload();
                } else {
                    console.error('Failed to save:', response.statusText);
                }
            } catch (error) {
                console.error("Error saving status:", error);
            }
        },

        async closeModal() {
            this.showUnemployedModal = false;
            await this.submitForm();
        }
    }
}
