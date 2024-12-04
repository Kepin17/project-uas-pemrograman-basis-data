<section class="form-wrapper border-2 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 
bg-white p-8 rounded-lg shadow-lg hidden" id="addUserModal">
<form action="">
<div class="form-header text-center mb-5">
    <h1 class="text-2xl font-bold mb-2">Member Registration</h1>
    <p>Fill out the form below to register as an admin</p>
</div>

<div class="form-group flex gap-4">
    <div class="form-batas flex flex-col gap-2">
        <label for="firstname">First Name</label>
        <input type="text" name="firstname" id="firstname" class="focus:outline-none border-2 rounded-sm p-2">
    </div>
    
    <div class="form-batas flex flex-col gap-2">
        <label for="lastname">Last Name</label>
        <input type="text" name="lastname" id="lastname" class="focus:outline-none border-2 rounded-sm p-2">
    </div>
</div>

<div class="form-group w-full flex flex-col gap-2">
    <label for="email">Email</label>
    <input type="email" name="email" id="email" class="focus:outline-none border-2 rounded-sm p-2">
    </div>
    
    <div class="form-group w-full flex flex-col gap-2">
        <label for="address">Address</label>
        <input type="text" name="address" id="address" class="focus:outline-none border-2 rounded-sm p-2">
    </div>
    
    <div class="form-group w-full flex flex-col gap-2">
        <label for="phone">Phone Number</label>
        <div class="flex">
            <select name="phone_code" id="phone_code" class="focus:outline-none border-2 rounded-l-sm p-2 w-1/4">
                <option value="">Select</option>
                <?php foreach($phoneCodes as $code => $country): ?>
                    <option value="<?php echo $code; ?>"><?php echo $code . ' ' . $country; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="tel" name="phone" id="phone" class="focus:outline-none border-2 border-l-0 rounded-r-sm p-2 w-3/4" 
                placeholder="Enter phone number">
        </div>
    </div>

    <div class="flex justify-end gap-2 mt-4">
        <button type="button" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200" onclick="destroyModal()">Cancel</button>
        <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">Save</button>
    </div>
</form>
</section>

<script>
    const destroyModal = () => {
        const modal = document.getElementById('addUserModal');
        modal.classList.add('hidden');
    }
</script>