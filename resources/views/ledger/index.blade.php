<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Ledger Book') }}
    </h2>
    <a href="{{ route('ledgers.import') }}" class="bg-blue-300 hover:bg-blue-400 text-blue-800 font-bold py-2 px-4 rounded inline-flex items-center">
      <span>Excel Import</span>
    </a>
    <a href="{{ route('ledgers.create') }}" class="bg-blue-300 hover:bg-blue-400 text-blue-800 font-bold py-2 px-4 rounded inline-flex items-center">
      <span>Create New</span>
    </a>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <div class="container text-sm">

            <fieldset class="border border-solid rounded-md border-gray-300 p-3 mb-5">
              <legend class="text-sm">Search</legend>
              <div class="mt-3 md:mt-0 md:col-span-2">
                <form>
                  <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-2 py-3 bg-white sm:p-3">
                      <div class="grid grid-cols-6 gap-3">
                        <div class="col-span-2 sm:col-span-2">
                          <label for="ac_no" class="block text-sm font-medium text-gray-700">A/C No.</label>
                          <select id="ac_no" name="ac_no" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required autofocus>
                            <option value="">Select</option>
                            @foreach($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->ac_no.' ('.$account->bank_name.')'}}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-span-2 sm:col-span-2">
                          <label for="datepicker_frm" class="block text-sm font-medium text-gray-700">From Date.</label>
                          <input type="text" name="from_date" id="frm_dt" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                        <div class="col-span-2 sm:col-span-2">
                          <label for="datepicker_to" class="block text-sm font-medium text-gray-700">To Date</label>
                          <input type="text" name="to_date" id="to_dt" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>

                      </div>
                    </div>
                    <div class="px-4 py-1 bg-gray-50 text-right sm:px-6">
                      <button type="button" onclick="getLedgerListFn()" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Search
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </fieldset>

            <div class="flex flex-col">
              <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                  <div class="shadow overflow-hidden border-b border-gray-300 sm:rounded-lg">
                    <table id="ledgersTable" class="display" style="width:100%">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Particulars</th>
                          <th>Cheque No.</th>
                          <th>Date</th>
                          <th>Amount</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    var dataTab = "";

    $(document).ready(function() {

      $("#frm_dt").datepicker({
        dateFormat: "yy-mm-dd"
      });
      $("#to_dt").datepicker({
        dateFormat: "yy-mm-dd"
      });

      $("#ledgersTable").on('click', '.delete', function(e) {
        if (!confirm("Are you sure you want to delete this record?")) {
          return false;
        }

        e.preventDefault();

        var row = $(this).closest('tr');
        var table = $('#ledgersTable').DataTable();
        var id = table.row(row).data().id;
        var token = $("meta[name='csrf-token']").attr("content");
        var url = e.target;

        $.ajax({
          url: url.href, //or you can use url: "company/"+id,
          method: "DELETE",
          data: {
            _token: token,
            id: id
          },
          success: function(data) {
            //getLedgerListFn();
            $('#ledgersTable').DataTable().row($(this).parents('tr')).remove().draw();
          }
        });
      });

      getLedgerListFn();
    });

    function getLedgerListFn() {
      id = $("#ac_no").val();
      id = id != "" ? id : 0;
      var toDay = new Date().toISOString().slice(0, 10);
      frmdt = $("#frm_dt").val() != "" ? $("#frm_dt").val() : toDay;
      todt = $("#to_dt").val() != "" ? $("#to_dt").val() : toDay;

      $.ajax({
        type: "get",
        //url: "/get-ledger-data/" + id + "/" + frmdt + "/" + todt,
        url: "{{ URL::to('get-ledger-data') }}/" + id + "/" + frmdt + "/" + todt,
        data: "",
        dataType: "json",
        success: function(data) {
          //debugger
          //console.log(data);
          dataTab = $('#ledgersTable').DataTable({
            "aaData": data,
            "columns": [{
                "data": "id"
              },
              {
                "data": "name"
              },
              {
                "data": "particulars"
              },
              {
                "data": "cheque_no"
              },
              {
                "data": "issue_date"
              },
              {
                "data": "amount"
              },
              {
                "data": function(data, type, row, meta) {
                  var uri = "";
                  urie = "{{ route('ledgers.edit','lid')}}";
                  urid = "{{ route('ledgers.destroy','lid')}}";
                  urie = urie.replace('lid', data.id);
                  urid = urid.replace('lid', data.id);
                  return '<a href="' + urie + '" class = "editor-edit"> Edit</a> | <a href="' + urid + '" class="delete">Delete</a > ';
                },
                "className": "text-indigo-600 hover:text-indigo-900",
                "orderable": false,
              },
            ],
            "columnDefs": [{
              "targets": [0],
              "visible": false,
            }, ]
          });
        }
      });
      dataTab.destroy();
    }
  </script>
</x-app-layout>