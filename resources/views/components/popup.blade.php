<div id="info-popup"tabindex="-1" x-data="popupScript" x-init="setModal"
    class="hidden max-w-[400px] mx-auto overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full">
    <div class="relative p-4 w-full max-w-lg m-auto">
        <div class="relative p-4 rounded-lg shadow text-white"
            :class="{ 'bg-danger': error !== null, 'bg-main': success !== null }">
            <div class="mb-4 font-ligh">
                <p x-text="error || success" class="text-center text-balance"></p>
            </div>
            <div class="justify-between items-center pt-0 space-y-4 sm:flex sm:space-y-0">

                <div class="items-center w-full">
                    <button id="close-modal" type="button" class="w-full p-1 rounded-md bg-pale text-dark"
                        x-on:click="closeModal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        function popupScript() {
            return {
                modal: null,
                error: @js($errors->all()[0] ?? null),
                success: @js(session('success') ?? null),
                setModal: function() {
                    const modalEl = document.getElementById('info-popup');
                    this.modal = new Modal(modalEl, {
                        placement: 'center'
                    });

                    if (this.error !== null || this.success) this.showModal()

                },
                closeModal: function() {
                    this.modal.hide()
                },
                showModal: function() {
                    this.modal.show()
                }
            }
        }
    </script>
@endpush
