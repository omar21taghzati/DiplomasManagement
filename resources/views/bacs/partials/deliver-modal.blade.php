<div class="modal fade" id="showDeliverBacModal" tabindex="-1" aria-labelledby="RequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Wider modal -->
        <div class="modal-content shadow-lg rounded-3">
            <div class="modal-header bg-brown-header text-white">
                <h5 class="modal-title" id="RequestModalLabel">Deliver Bac</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="alert alert-success" style="display: none;" id='msg-success'></div>

                <form method="POST" id='deliverBac'>
                    {{-- @csrf --}}
                    <input type="hidden" id="editStagiaireId" name="stagiaire_id">
                    <div class="mb-3">
                        <label for="date">Date Taken Bac</label>
                        <input type="date" name="taken_date" class="form-control">
                        <p class="text-red-500 text-xs mt-2 text-danger" id='error_taken_date'></p>
                    </div>

                    {{-- <div class="mb-3">
                        <label for="notes">status</label>
                        <select name="status" class="form-control" id="choiceStatus">
                            <option value="delivered">delivered</option>
                            <option value="undelivered">undelivered</option>
                            <option value="reserved">reserved</option>
                        </select>
                    </div>

                    <div class="mb-3" style="display: none;" id="takeDuration">
                        <label for="date">taking duration</label>
                        <input type="number" name="taking_duration" class="form-control">
                        <p class="text-red-500 text-xs mt-2 text-danger" id='error_takin_duration'></p>
                    </div> --}}

                    <div class="mb-3">
                        <label for="choiceStatus" class="form-label">Status</label>
                        <select name="status" id="choiceStatus" class="form-control" required>
                            <option value="delivered">Delivered</option>
                            <option value="reserved">Reserved</option>
                        </select>
                    </div>

                    <div class="mb-3 d-none" id="takeDuration">
                        <label for="taking_duration" class="form-label">Taking Duration</label>
                        <input type="number" id="taking_duration" name="taking_duration" class="form-control">
                        <p class="text-danger small mt-1" id="error_taking_duration"></p>
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
        // document.getElementById('choiceStatus').addEventListener('change', function(e) {
        //     const status = e.target.value;
        //     console.log(status);
        //     switch (status) {
        //         case "reserved":
        //             document.getElementById('takeDuration').style.display = "block";
        //             break;
        //         default:
        //             document.getElementById('takeDuration').style.display = "none";
        //             break;
        //     }
        // })




        document.getElementById('choiceStatus').addEventListener('change', function(e) {
            const durationSection = document.getElementById('takeDuration');
            if (e.target.value === 'reserved') {
                durationSection.classList.remove('d-none');
                document.getElementById('taking_duration').value = '';
            } else {
                durationSection.classList.add('d-none');
            }
        });

        document.getElementById('deliverBac').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            // console.log(e.target);

            const formData = new FormData(form);
            //  console.log(formData);
            const id = document.getElementById('editStagiaireId').value;
            console.log(id);
            axios.post(`/bacs/deliver/${id}`, formData)
                .then(response => {
                    console.log(response);
                    document.getElementById('error_taken_date').innerHTML = "";
                    document.getElementById('error_taking_duration').innerHTML = "";

                    document.getElementById('msg-success').style.display = "block";
                    document.getElementById('msg-success').innerHTML = response.data.message;

                    // $('#showFormRequestModal').modal('hide');
                    window.location.reload();
                })
                .catch(error => {
                    if (error.response && error.response.data.errors) {
                        const errors = error.response.data.errors;
                        console.log(errors);
                        if (errors.taken_date) {
                            document.getElementById('error_taken_date').innerText = errors.taken_date[0];
                        }

                        if (errors.taking_duration) {
                            document.getElementById('error_taking_duration').innerText = errors.taking_duration[
                                0];
                        }

                    } else {
                        console.error('Unexpected error:', error);
                    }
                });

        });

        document.getElementById('showDeliverBacModal').addEventListener('hidden.bs.modal', function() {
            this.querySelector('form').reset(); // Reset form fields
            document.getElementById('msg-success').style.display = "none";
            this.querySelectorAll('.text-danger').forEach(el => el.innerHTML = ''); // Clear error messages
        });
    </script>
@endpush
