<form method="POST" enctype="multipart/form-data">
    <label for="name">Pet Name:</label>
    <input name="name" placeholder="Name" id="name" required />

    <label for="species">Species:</label>
    <input name="species" placeholder="Species" id="species" required />

    <label for="breed">Breed</label>
    <input name="breed" id="breed" placeholder="Breed" required />

    <label for="age">Age</label>
    <input name="age" id="age" type="number" placeholder="Age" min="1" max="40" required />

    <label for="gender">Gender</label>
    <select name="gender" id="gender">
        <option value="unknown" selected>Unknown</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
    </select>

    <label for="description">Description</label>
    <textarea name="description" id="description" placeholder="Description"></textarea>

    <label for="status">Status</label>
    <select name="status" id="status">
        <option value="available" selected>Available</option>
        <option value="adopted">Adopted</option>
    </select>

    <label for="location">Location</label>
    <input name="location" id="location" placeholder="Location" required />

    <label for="image">Upload photos</label>
    <input type="file" name="images[]" accept="image/*" multiple required />
    <button type="submit">Create listing</button>
</form>
