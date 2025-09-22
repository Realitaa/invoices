@extends('layouts.app')

@section('title', 'Insert Invoice')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Form Header -->
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900">Create New Invoice</h2>
            <p class="mt-1 text-sm text-gray-600">Fill in the details below to create a new invoice record.</p>
        </div>

        <!-- Form Body -->
        <form action="{{ route('invoice.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <!-- Row 1: ID and Account ID -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="id" class="block text-sm font-medium text-gray-700 mb-2">
                        ID <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="id"
                           name="id"
                           value="{{ old('id') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('id') border-red-500 @enderror"
                           placeholder="Enter ID"
                           required>
                    @error('id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="account_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Account ID <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="account_id"
                           name="account_id"
                           value="{{ old('account_id') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('account_id') border-red-500 @enderror"
                           placeholder="Enter Account ID"
                           required>
                    @error('account_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Row 2: NPWP and Amount -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="npwp" class="block text-sm font-medium text-gray-700 mb-2">
                        NPWP <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="npwp"
                           name="npwp"
                           value="{{ old('npwp') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('npwp') border-red-500 @enderror"
                           placeholder="Enter NPWP"
                           required>
                    @error('npwp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                        Amount <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                        <input type="number"
                               id="amount"
                               name="amount"
                               value="{{ old('amount') }}"
                               step="0.01"
                               min="0"
                               class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('amount') border-red-500 @enderror"
                               placeholder="0.00"
                               required>
                    </div>
                    @error('amount')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Row 3: Reason and Payment -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Reason <span class="text-red-500">*</span>
                    </label>
                    <textarea id="reason"
                              name="reason"
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('reason') border-red-500 @enderror"
                              placeholder="Enter reason for invoice"
                              required>{{ old('reason') }}</textarea>
                    @error('reason')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="payment" class="block text-sm font-medium text-gray-700 mb-2">
                        Payment Method <span class="text-red-500">*</span>
                    </label>
                    <select id="payment"
                            name="payment"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('payment') border-red-500 @enderror"
                            required>
                        <option value="">Select Payment Method</option>
                        <option value="bank_transfer" {{ old('payment') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                        <option value="cash" {{ old('payment') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="check" {{ old('payment') == 'check' ? 'selected' : '' }}>Check</option>
                        <option value="credit_card" {{ old('payment') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                    </select>
                    @error('payment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Row 4: Flagging and Due Date -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="flagging" class="block text-sm font-medium text-gray-700 mb-2">
                        Flagging Status
                    </label>
                    <select id="flagging"
                            name="flagging"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('flagging') border-red-500 @enderror">
                        <option value="">Select Status</option>
                        <option value="normal" {{ old('flagging') == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="urgent" {{ old('flagging') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                        <option value="priority" {{ old('flagging') == 'priority' ? 'selected' : '' }}>Priority</option>
                        <option value="review" {{ old('flagging') == 'review' ? 'selected' : '' }}>Under Review</option>
                    </select>
                    @error('flagging')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Due Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date"
                           id="due_date"
                           name="due_date"
                           value="{{ old('due_date') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('due_date') border-red-500 @enderror"
                           required>
                    @error('due_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Row 5: Note (Full Width) -->
            <div>
                <label for="note" class="block text-sm font-medium text-gray-700 mb-2">
                    Additional Notes
                </label>
                <textarea id="note"
                          name="note"
                          rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('note') border-red-500 @enderror"
                          placeholder="Enter any additional notes or comments">{{ old('note') }}</textarea>
                @error('note')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Row 6: Checkboxes and Delayed Reason -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="flex items-center">
                        <input type="checkbox"
                               id="accepted_invoice"
                               name="accepted_invoice"
                               value="1"
                               {{ old('accepted_invoice') ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="accepted_invoice" class="ml-2 block text-sm text-gray-700">
                            Invoice Accepted
                        </label>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Check if the invoice has been accepted</p>
                    @error('accepted_invoice')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="delayed_paying_reason" class="block text-sm font-medium text-gray-700 mb-2">
                        Delayed Payment Reason
                    </label>
                    <textarea id="delayed_paying_reason"
                              name="delayed_paying_reason"
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('delayed_paying_reason') border-red-500 @enderror"
                              placeholder="Enter reason for delayed payment (if applicable)">{{ old('delayed_paying_reason') }}</textarea>
                    @error('delayed_paying_reason')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('invoice.index') }}"
                   class="px-6 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    Create Invoice
                </button>
            </div>
        </form>
    </div>
</div>
@endsection