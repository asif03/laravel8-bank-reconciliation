<x-app-layout>
  <x-slot name="header" class="flex justify-between">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Ledger Book') }}
    </h2>
    <a href="{{ route('ledgers.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
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
                  <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Ledger Book Information</h3>
                </div>
              </div>
              <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('ledgers.update', $ledger->id) }}" method="POST">
                  @method('PATCH')
                  @csrf
                  <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                      <x-alert />
                      <div class="grid grid-cols-6 gap-6">
                        <div class="col-span-6 sm:col-span-3">
                          <label for="entry_type_dis" class="block text-sm font-medium text-gray-700">Entry Type</label>
                          <select id="entry_type_dis" name="entry_type_dis" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required disabled>
                            <option value="LED" @if ($ledger->entry_type==='LED') selected @endif>Ledger</option>
                            <option value="ADJ">Adjustment</option>
                          </select>
                          <input type="hidden" name="entry_type" value="{{ $ledger->entry_type }}" />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                          <label for="bank_id_dis" class="block text-sm font-medium text-gray-700">A/C No.</label>
                          <select id="bank_id_dis" name="bank_id_dis" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required disabled>
                            <option value="">Select</option>
                            @foreach($accounts as $account)
                            <option value="{{ $account->id }}" @if ($ledger->bank_id===$account->id) selected @endif>{{ $account->ac_no.' ('.$account->bank_name.')'}}</option>
                            @endforeach
                          </select>
                          <input type="hidden" name="bank_id" value="{{ $ledger->bank_id }}" />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                          <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                          <input type="text" name="name" id="name" value="{{$ledger->name}}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required autofocus>
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                          <label for="particulars" class="block text-sm font-medium text-gray-700">Particulars</label>
                          <input type="text" name="particulars" id="particulars" value="{{$ledger->particulars}}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required autofocus>
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                          <label for="cheque_no" class="block text-sm font-medium text-gray-700">Cheque No.</label>
                          <input type="text" name="cheque_no" id="cheque_no" value="{{$ledger->cheque_no}}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                          <label for="issue_date" class="block text-sm font-medium text-gray-700">Date</label>
                          <input type="text" name="issue_date" id="datepicker" value="{{$ledger->issue_date}}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                          <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                          <input type="text" name="amount" id="amount" value="{{$ledger->amount}}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
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

  <script>
    $(function() {
      $("#datepicker").datepicker({
        dateFormat: "yy-mm-dd"
      });
    });
  </script>

</x-app-layout>