<x-app-layout>
  <x-slot name="header" class="flex justify-between">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Bank Statement Excel Import') }}
    </h2>
    <a href="{{ route('statements.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
      <span>Back</span>
    </a>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">

          <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
              <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                  <h3 class="text-lg font-medium leading-6 text-gray-900">Upload A/C Statement</h3>
                </div>
              </div>
              <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('statements.import-create') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                      <x-alert />
                      <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                          <label for="ac_no" class="block text-sm font-medium text-gray-700">A/C No.</label>
                          <select id="ac_no" name="ac_no" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required autofocus>
                            <option value="">Select</option>
                            @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->ac_no.' ('.$account->bank_name.')'}}</option>
                            @endforeach
                          </select>
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                          <label class="block text-sm font-medium text-gray-700">
                            Select File
                          </label>
                          <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                              <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                              </svg>
                              <div class="flex text-sm text-gray-600">
                                <label for="execl_file" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                  <span>Upload a file</span>
                                  <input id="execl_file" name="execl_file" type="file" class="sr-only" value="{{ csrf_token() }}" />
                                </label>
                                <p class="pl-1">or drag and drop</p>
                              </div>
                              <p class="text-xs text-gray-500">
                                Excel
                              </p>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                      <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Save
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(function() {
      $("#datepicker").datepicker({
        dateFormat: "yy-mm-dd"
      });
    });
  </script>

</x-app-layout>