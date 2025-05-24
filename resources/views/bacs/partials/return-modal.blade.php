<div class="modal fade" id="showReturnBacModal" tabindex="-1" aria-labelledby="RequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Wider modal -->
        <div class="modal-content shadow-lg rounded-3">
            <div class="modal-header bg-brown-header text-white">
                <h5 class="modal-title" id="RequestModalLabel">Return Bac</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="alert alert-success" style="display: none;" id='msg'>Bac returned successfully
                </div>

                <form method="POST" id='returnBac'>

                    <input type="hidden" id="editStagiaireId" name="stagiaire_id">
                    <div class="mb-3">
                        <label>Date Return Bac</label>
                        <input type="date" name="return_date" class="form-control">
                        <p class="text-red-500 text-xs mt-2 text-danger" id='error_return_date'></p>
                    </div>

                    <div class="mb-3">
                        <label>Notes</label>
                        <textarea name="additional_notes" class="form-control"></textarea>
                    </div>

                    <button type="submit" class="btn bg-brown-header text-white">return</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.getElementById('returnBac').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            // console.log(e.target);
            const formData = new FormData(form);
            // console.log(formData);
            const id = document.getElementById('editStagiaireId').value;
            console.log(id);
            axios.post(`/bacs/return/${id}`, formData)
                .then(response => {
                    console.log(response);
                    document.getElementById('error_return_date').innerHTML = "";

                    document.getElementById('msg').style.display = "block";
                    // document.getElementById('msg-success1').innerHTML = response.data.message;
                    // $('#showFormRequestModal').modal('hide');
                    window.location.reload();
                })
                .catch(error => {
                    if (error.response && error.response.data.errors) {
                        const errors = error.response.data.errors;
                        console.log(errors);
                        if (errors.return_date) {
                            document.getElementById('error_return_date').innerText = errors.return_date[0];
                        }

                    } else {
                        console.error('Unexpected error:', error);
                    }
                });

        });

        document.getElementById('showReturnBacModal').addEventListener('hidden.bs.modal', function() {
            this.querySelector('form').reset(); // Reset form fields
            document.getElementById('msg-success').style.display = "none";
            this.querySelectorAll('.text-danger').forEach(el => el.innerHTML = ''); // Clear error messages
        });
    </script>
@endpush
