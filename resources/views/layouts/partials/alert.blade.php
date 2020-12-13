<div id="alert"
    class="px-6 py-2 border-0 rounded-lg shadow-lg {{ flash()->class == 'danger'? 'bg-red-500' : 'bg-arwad-500' }} fixed bottom-0 right-0 mx-4 md:mx-0 md:w-70 z-50 md:mr-16 mb-10 flex items-center justify-between">
    <span class="inline-block align-middle text-white text-sm">
        {{ flash()->message }}
    </span>
    <button onclick="closeAlert()" class="bg-transparent outline-none focus:outline-none">
        <span class="text-xs font-bold leading-none text-white">
            Done
        </span>
    </button>
</div>

@push('scripts')
<script>
    function closeAlert(){
          document.querySelector('#alert').classList.add('hidden');
        }
        if (! document.querySelector('#alert').classList.contains("hidden")){
          setTimeout(() => {
            closeAlert();
          }, 3000)
        }
</script>
@endpush
