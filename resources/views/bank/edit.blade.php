<x-app-layout>
  <x-slot name="header" class="flex justify-between">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Bank Info') }}
    </h2>
    <a href="{{ route('banks.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
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
                  <h3 class="text-lg font-medium leading-6 text-gray-900">Update Bank Information</h3>
                </div>
              </div>
              <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('banks.update', $bank->id) }}" method="POST">
                  @method('PATCH')
                  @csrf
                  <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                      <x-alert />
                      <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                          <label for="bank_name" class="block text-sm font-medium text-gray-700">Bank name</label>
                          <input type="text" name="bank_name" id="bank_name" value="{{$bank->bank_name}}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                          <label for="branch_name" class="block text-sm font-medium text-gray-700">Branch name</label>
                          <input type="text" name="branch_name" id="branch_name" value="{{$bank->branch_name}}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                          <label for="ac_no" class="block text-sm font-medium text-gray-700">A/C No.</label>
                          <input type="text" name="ac_no" id="ac_no" value="{{$bank->ac_no}}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                          <label for="ac_title" class="block text-sm font-medium text-gray-700">A/C Title</label>
                          <input type="text" name="ac_title" id="ac_title" value="{{$bank->ac_title}}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                          <label for="ac_type" class="block text-sm font-medium text-gray-700">A/C Type</label>
                          <input type="text" name="ac_type" id="ac_type" value="{{$bank->ac_type}}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-6">
                          <label for="branch_address" class="block text-sm font-medium text-gray-700">Address</label>
                          <input type="text" name="branch_address" id="branch_address" value="{{$bank->branch_address}}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-6">
                          <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                          <textarea id="remarks" name="remarks" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md">{{$bank->remarks}}</textarea>
                        </div>

                      </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                      <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update
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
</x-app-layout>