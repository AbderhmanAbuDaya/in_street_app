// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getMessaging,getToken,onMessage   } from "firebase/messaging";

// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyB0xgRGw2VJbdkz0DbXKa3QuZF8HvtwRVg",
    authDomain: "public-in-street.firebaseapp.com",
    projectId: "public-in-street",
    storageBucket: "public-in-street.appspot.com",
    messagingSenderId: "843374404733",
    appId: "1:843374404733:web:c6b8ef4f8afb256a38bd14",
    measurementId: "G-894PDMK9KG"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

const messaging = getMessaging();
getToken(messaging, { vapidKey: 'BBrC_wbZmLjIv8XS-wKPuHQAFuxmkLo3oy0D3rh-xLpqxNoCRnNZIORWnaR9e3O4tLalwPQ3iTpCzxvvIiLxn3g' }).then((currentToken) => {
    if (currentToken) {
        console.log(currentToken);

    } else {
        // Show permission request UI
        console.log('No registration token available. Request permission to generate one.');
        // ...
    }
}).catch((err) => {
    console.log('An error occurred while retrieving token. ', err);
    // ...
});

onMessage(messaging, (payload) => {
    console.log('Message received. ', payload);
});
