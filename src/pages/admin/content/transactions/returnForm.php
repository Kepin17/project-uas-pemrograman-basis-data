<section class="form-wrapper border-2 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 
bg-white p-8 rounded-lg shadow-lg hidden" id="returnModal">
    <form action="" class="flex flex-wrap -mx-2">
        <div class="w-full px-2 mb-5">
            <div class="form-header text-center">
                <h1 class="text-2xl font-bold mb-2">Process Book Return</h1>
                <p>Fill out the form below to process a book return</p>
            </div>
        </div>

        <div class="w-1/2 px-2 mb-4">
            <div class="form-group flex flex-col gap-2">
                <label for="transaction">Borrowing Transaction</label>
                <select name="transaction" id="transaction" class="focus:outline-none border-2 rounded-sm p-2" onchange="calculateFine()">
                    <option value="">Select Transaction</option>
                    <option value="TRX-001">TRX-001 - John Doe - The Great Gatsby</option>
                    <option value="TRX-002">TRX-002 - Jane Smith - To Kill a Mockingbird</option>
                    <option value="TRX-003">TRX-003 - Bob Johnson - 1984</option>
                </select>
            </div>

            <div class="form-group flex flex-col gap-2 mt-4">
                <label for="return_date">Return Date</label>
                <input type="date" name="return_date" id="return_date" 
                    class="focus:outline-none border-2 rounded-sm p-2"
                    value="<?php echo date('Y-m-d'); ?>"
                    onchange="calculateFine()">
            </div>

            <div class="form-group flex flex-col gap-2 mt-4">
                <label for="condition">Book Condition</label>
                <select name="condition" id="condition" class="focus:outline-none border-2 rounded-sm p-2">
                    <option value="good">Good</option>
                    <option value="damaged">Damaged</option>
                    <option value="lost">Lost</option>
                </select>
            </div>
        </div>

        <div class="w-1/2 px-2 mb-4">
            <div id="transactionDetails" class="mb-4 p-4 bg-gray-50 rounded-lg hidden">
                <h3 class="font-semibold mb-2">Transaction Details</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-600">Member:</p>
                        <p class="font-medium" id="memberDetail"></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Book:</p>
                        <p class="font-medium" id="bookDetail"></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Borrow Date:</p>
                        <p class="font-medium" id="borrowDateDetail"></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Due Date:</p>
                        <p class="font-medium" id="dueDateDetail"></p>
                    </div>
                </div>
            </div>

            <div id="fineDetails" class="mb-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200 hidden">
                <h3 class="font-semibold mb-2 text-yellow-800">Fine Details</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Days Overdue:</span>
                        <span class="font-medium" id="daysOverdue"></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Fine per Day:</span>
                        <span class="font-medium">Rp 5.000</span>
                    </div>
                    <div class="flex justify-between text-lg font-semibold text-yellow-800 pt-2 border-t border-yellow-200">
                        <span>Total Fine:</span>
                        <span id="totalFine"></span>
                    </div>
                </div>
            </div>

            <div class="form-group flex flex-col gap-2 mt-4">
                <label for="notes">Notes</label>
                <textarea name="notes" id="notes" rows="3" 
                    class="focus:outline-none border-2 rounded-sm p-2"
                    placeholder="Any additional notes about the return..."></textarea>
            </div>
        </div>

        <div class="w-full px-2 mt-4">
            <div class="flex justify-end gap-2">
                <button type="button" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200" 
                    onclick="destroyReturnModal()">Cancel</button>
                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Process Return</button>
            </div>
        </div>
    </form>
</section>

<script>
    const dummyData = [
        { id: 'TRX-001', member: 'John Doe', book: 'The Great Gatsby', borrowDate: '2024-11-01', dueDate: '2024-06-15' },
        { id: 'TRX-002', member: 'Jane Smith', book: 'To Kill a Mockingbird', borrowDate: '2024-06-05', dueDate: '2024-06-19' },
        { id: 'TRX-003', member: 'Bob Johnson', book: '1984', borrowDate: '2023-06-10', dueDate: '2024-06-24' }
    ];

    const destroyReturnModal = () => {
        const modal = document.getElementById('returnModal');
        modal.classList.add('hidden');
    }

    const calculateFine = () => {
        const transaction = document.getElementById('transaction').value;
        if (!transaction) return;

        const selectedTransaction = dummyData.find(t => t.id === transaction);
        if (!selectedTransaction) return;

        document.getElementById('memberDetail').textContent = selectedTransaction.member;
        document.getElementById('bookDetail').textContent = selectedTransaction.book;
        document.getElementById('borrowDateDetail').textContent = selectedTransaction.borrowDate;
        document.getElementById('dueDateDetail').textContent = selectedTransaction.dueDate;

        document.getElementById('transactionDetails').classList.remove('hidden');

        const calculateTotalFine = () => {
            const bookCondition = document.getElementById('condition').value;
            const returnDate = new Date(document.getElementById('return_date').value);
            const dueDate = new Date(selectedTransaction.dueDate);
            let totalFine = 0;
            let bookConditionFee = 0;

            if (returnDate > dueDate) {
                const diffTime = Math.abs(returnDate - dueDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                const finePerDay = 5000;
                totalFine = diffDays * finePerDay;

                document.getElementById('daysOverdue').textContent = diffDays + ' days';
            } else {
                document.getElementById('daysOverdue').textContent = '0 days';
            }

            if (bookCondition === 'lost') {
                bookConditionFee = 500000;
            } else if (bookCondition === 'damaged') {
                bookConditionFee = 100000;
            }

            totalFine += bookConditionFee;

            document.getElementById('totalFine').textContent = 'Rp ' + totalFine.toLocaleString('id-ID');
            document.getElementById('fineDetails').classList.remove('hidden');
        };

        calculateTotalFine();

        document.getElementById('condition').addEventListener('change', calculateTotalFine);
        document.getElementById('return_date').addEventListener('change', calculateTotalFine);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const transactionSelect = document.getElementById('transaction');
        transactionSelect.addEventListener('change', (e) => {
            if (e.target.value) {
                calculateFine();
            } else {
                document.getElementById('transactionDetails').classList.add('hidden');
                document.getElementById('fineDetails').classList.add('hidden');
            }
        });
    });
</script>
