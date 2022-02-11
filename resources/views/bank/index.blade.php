<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Bank Info') }}
    </h2>
    <a href="{{ route('banks.create') }}" class="bg-blue-300 hover:bg-blue-400 text-blue-800 font-bold py-2 px-4 rounded inline-flex items-center">
      <span>Create New</span>
    </a>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <div class="container">
            <div class="flex flex-col">
              <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                  <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <x-alert />
                    <table class="min-w-full divide-y divide-gray-200 table-auto">
                      <thead class="bg-gray-50">
                        <tr>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Bank Name
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Branch Name
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            A/C No.
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            A/C Title
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            A/C Type
                          </th>
                          <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            A/C Status
                          </th>
                          <th scope="col" class="relative px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($banks as $bank)
                        <tr>
                          <td class="px-6 py-4 whitespace-nowrap">
                            {{ $bank->bank_name }}
                          </td>
                          <td class="px-6 py-4">
                            {{ $bank->branch_name }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            {{ $bank->ac_no }}
                          </td>
                          <td class="px-6 py-4">
                            {{ $bank->ac_title }}
                          </td>
                          <td class="px-6 py-4">
                            {{ $bank->ac_type }}
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap">
                            @if($bank->is_active==1)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                              Active
                            </span>
                            @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                              In Active
                            </span>
                            @endif
                          </td>
                          <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('banks.edit', $bank->id) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a> |
                            @if($bank->is_active==1)
                            <button onclick="event.preventDefault();document.getElementById('form-inactive-{{ $bank->id }}').submit()" class="text-indigo-600 hover:text-indigo-900">Inactive</button>
                            <form class="hidden" id="{{'form-inactive-'.$bank->id}}" action="{{ route('bank.inactive', $bank->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                            </form>
                            @else
                            <button onclick="event.preventDefault();document.getElementById('form-active-{{ $bank->id }}').submit()" class="text-indigo-600 hover:text-indigo-900">Active</button>
                            <form class="hidden" id="{{'form-active-'.$bank->id}}" action="{{ route('bank.active', $bank->id) }}" method="POST">
                              @csrf
                              @method('PUT')
                            </form>
                            @endif
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="pt-2">
            {{ $banks->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>