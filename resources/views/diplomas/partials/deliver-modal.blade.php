<div class="modal fade" id="showDeliverDiplomaModal" tabindex="-1" aria-labelledby="RequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Wider modal -->
        <div class="modal-content shadow-lg rounded-3">
            <div class="modal-header bg-brown-header text-white">
                <h5 class="modal-title" id="RequestModalLabel">Deliver Diploma</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="alert alert-success" style="display: none;" id='msg-success'>diploma delivered successfully
                </div>

                <form method="POST" id='deliverDiploma'>
                    {{-- @csrf --}}
                    <input type="hidden" id="editStagiaireId" name="stagiaire_id">
                    <div class="mb-3">
                        <label for="date">Date Taken Diploma</label>
                        <input type="date" name="taken_date" class="form-control">
                        <p class="text-red-500 text-xs mt-2 text-danger" id='error_taken_date'></p>
                    </div>

                    <div class="mb-3">
                        <label for="notes">Notes</label>
                        <textarea name="additional_notes" class="form-control"></textarea>
                    </div>
                    <button type="submit" class="btn bg-brown-header text-white">deliver</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        document.getElementById('deliverDiploma').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const id = document.getElementById('editStagiaireId').value;
            console.log(id);
            axios.post(`/diplomas/deliver/${id}`, formData)
                .then(response => {
                    console.log(response);
                    document.getElementById('error_taken_date').innerHTML = "";
                    // document.getElementById('error_details').innerHTML = "";

                    document.getElementById('msg-success').style.display = "block";

                    // $('#showFormRequestModal').modal('hide');
                     window.location.reload();
                })
                .catch(error => {
                    if (error.response && error.response.data.errors) {
                        const errors = error.response.data.errors;
                        if (errors.taken_date) {
                            document.getElementById('error_taken_date').innerText = errors.taken_date[0];
                        }
                    } else {
                        console.error('Unexpected error:', error);
                    }
                });

        });

        document.getElementById('showDeliverDiplomaModal').addEventListener('hidden.bs.modal', function() {
            this.querySelector('form').reset(); // Reset form fields
            document.getElementById('msg-success').style.display = "none";
            this.querySelectorAll('.text-danger').forEach(el => el.innerHTML = ''); // Clear error messages
        });
    </script>
@endpush
