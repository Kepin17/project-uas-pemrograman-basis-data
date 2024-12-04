<section class="form-wrapper border-2 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 
bg-white p-8 rounded-lg shadow-lg hidden" id="borrowModal">
    <form action="">
        <div class="form-header text-center mb-5">
            <h1 class="text-2xl font-bold mb-2">New Book Borrowing</h1>
            <p>Fill out the form below to process a book borrowing</p>
        </div>

        <!-- Member Selection -->
        <div class="form-group w-full flex flex-col gap-2 mb-4">
            <label for="member">Member</label>
            <select name="member" id="member" class="focus:outline-none border-2 rounded-sm p-2">
                <option value="">Select Member</option>
                <option value="1">John Doe</option>
                <option value="2">Jane Smith</option>
            </select>
        </div>

        <!-- Book Selection -->
        <div class="form-group w-full flex flex-col gap-2 mb-4">
            <label for="book">Book</label>
            <select name="book" id="book" class="focus:outline-none border-2 rounded-sm p-2">
                <option value="">Select Book</option>
                <option value="1">The Great Gatsby</option>
                <option value="2">To Kill a Mockingbird</option>
            </select>
        </div>

        <!-- Dates -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="form-group flex flex-col gap-2">
                <label for="borrow_date">Borrow Date</label>
                <input type="date" name="borrow_date" id="borrow_date" 
                    class="focus:outline-none border-2 rounded-sm p-2"
                    value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div class="form-group flex flex-col gap-2">
                <label for="due_date">Due Date</label>
                <input type="date" name="due_date" id="due_date" 
                    class="focus:outline-none border-2 rounded-sm p-2"
                    value="<?php echo date('Y-m-d', strtotime('+14 days')); ?>">
            </div>
        </div>

        <!-- Notes -->
        <div class="form-group w-full flex flex-col gap-2 mb-4">
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes" rows="3" 
                class="focus:outline-none border-2 rounded-sm p-2"
                placeholder="Any additional notes..."></textarea>
        </div>

        <div class="flex justify-end gap-2 mt-4">
            <button type="button" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200" 
                onclick="destroyBorrowModal()">Cancel</button>
            <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Process Borrowing</button>
        </div>
    </form>
</section>

<script>
    const destroyBorrowModal = () => {
        const modal = document.getElementById('borrowModal');
        modal.classList.add('hidden');
    }
</script>
