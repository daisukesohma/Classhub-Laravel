// be sure to have loaded
// <script src="https://www.gstatic.com/firebasejs/5.3.0/firebase.js"></script>
// before this script

// Initialize Firebase
var config = {
apiKey: "AIzaSyAl8LCaWAw59HWeqvICTlH3ibCe9oZSpzA",
authDomain: "thelittlegreenspoon.firebaseapp.com",
databaseURL: "https://thelittlegreenspoon.firebaseio.com",
projectId: "thelittlegreenspoon",
storageBucket: "thelittlegreenspoon.appspot.com",
messagingSenderId: "350098318208"
};

firebase.initializeApp(config);

db      = firebase.firestore();
storage = firebase.storage();


function getRecipes(){
    var recipes = [];
    return db.collection("recipes")
    .orderBy('name', 'asc')
    .get()
    .then(function(querySnapshot) {
        querySnapshot.forEach(function(doc) {
            var recipe = doc.data();
            recipe["id"] = doc.id;
            recipes.push(recipe);
        });
        return recipes;
    });
}

function getRecipe(id){
    return db.collection("recipes")
    .doc(id)
    .get()
    .then(function(snapshot) {
        var recipe = snapshot.data();
        recipe["id"] = snapshot.id;
        return recipe
    });
}

function updateRecipe(recipe){
     return db.collection("recipes")
    .doc(recipe.id)
    .set(recipe, { merge: true })
    .then(function(){
         return recipe
     })
}

function saveRecipe(recipe){
     return db.collection("recipes")
    .add(recipe)
    .then(function(doc){
        recipe["id"] = doc.id;
        return recipe;
    })
}

function deleteRecipe(recipeId){
     return db.collection("recipes")
            .doc(recipeId)
            .delete()
}

function getTags(){
    var tags = []
    return db.collection("tags")
    .orderBy('name', 'desc')
    .get()
    .then(function(querySnapshot) {
        querySnapshot.forEach(function(doc) {
            var tag = doc.data();
            tag["id"] = doc.id;
            tags.push(tag);
        });
        return tags;
    });
}

function getIngredients(){
    var ingredients = []
    return db.collection("ingredients")
    .orderBy('name', 'desc')
    .get()
    .then(function(querySnapshot) {
        querySnapshot.forEach(function(doc) {
            var ingredient = doc.data();
            ingredient["id"] = doc.id;
            ingredients.push(ingredient);
        });
        return ingredients;
    });
}


function saveTags(recipe){
  var batch = db.batch();

  recipe.tags.forEach(tag => {
    let ref = db.collection("tags").doc(tag.toLowerCase())
    batch.set(ref, {
      name: tag,
    })
  })

  return batch.commit()
  .then(function(data){
    return recipe
  })
}

function saveIngredients(recipe){
  var batch = db.batch();

  recipe.ingredients.forEach(ingredient => {
    let ref = db.collection("ingredients").doc(ingredient.name.toLowerCase())
    batch.set(ref, ingredient, {merge: true})
  })

  return batch.commit()
  .then(function(data){
    return recipe
  })
}

function saveIngredient(ingredient){

    return db.collection("ingredients")
    .doc(ingredient.name.toLowerCase())
    .set(ingredient, {merge: true})
    .then(function(doc){
       ingredient["id"] = ingredient.name.toLowerCase();
       return ingredient;
    })
}

function getUnits(){
    var units = []
    return db.collection("units")
    .orderBy('type', 'desc')
    .get()
    .then(function(querySnapshot) {
        querySnapshot.forEach(function(doc) {
            var unit = doc.data();
            unit["id"] = doc.id;
            units.push(unit);
        });
        return units;
    });
}

function getMealTypes(){
    var mealTypes = []
    return db.collection("mealTypes")
    .orderBy('order', 'asc')
    .get()
    .then(function(querySnapshot) {
        querySnapshot.forEach(function(doc) {
            var mealType = doc.data();
            mealType["id"] = doc.id;
            mealTypes.push(mealType);
        });
        return mealTypes;
    });
}

function uploadFile(recipe, key, file, type, name){

    const metadata = { contentType: file.type };

    ref = storage.ref().child(type+"/"+recipe.id+"/"+name);

    // save file to storage
    return ref.put(file, metadata)
    .then(function(snapshot) {
        // get the url
        return snapshot.ref.getDownloadURL()
    })
    .then(function(url) {
        // add url to recipe model
        var data = {}
        data[key] = url
         return db.collection("recipes")
        .doc(recipe.id)
        .set(data, { merge: true });
    })
    .then(function() {
        return recipe;
    })
}

// keeps uploading the images one by one and adding urls to recipe model until
// there are no images, then saves the updated recipe
function uploadImages(recipe, images, index=recipe.imageUrls.length){
  if(images.length == 0){
    return updateRecipe(recipe)
  }

  const file = images[0];
  const name = "image_"+index;
  const metadata = { contentType: file.type };

  ref = storage.ref().child("images/"+recipe.id+"/"+name);

  // save file to storage
  return ref.put(file, metadata)
  .then(function(snapshot) {
      // get the url
      return snapshot.ref.getDownloadURL()
  })
  .then(function(url) {
      var imageUrls = recipe.imageUrls;
      imageUrls.push(url);

      recipe.imageUrls = imageUrls
      images.splice(0, 1);

      return uploadImages(recipe, images, index + 1);
  })
}
