import store from "@/store";
import axios from "axios";

store.subscribe((mutation) => {
  switch (mutation.type) {
    case "auth/SET_TOKEN":
      if (mutation.payload) {
        axios.defaults.headers.common[
          "Authorization"
        ] = `Bearer ${mutation.payload}`;
        localStorage.setItem("token", mutation.payload);
      } else {
        axios.defaults.headers.common["Authorization"] = null;
        localStorage.removeItem("token");
      }

      break;
    case "auth/SET_USER":
      if (mutation.payload) {
        localStorage.setItem("user", JSON.stringify(mutation.payload));
      } else {
        localStorage.removeItem("user");
      }

      break;
    case "auth/SET_EXPIRATION_DATE":
      if (mutation.payload) {
        localStorage.setItem(
          "expiration_date",
          JSON.stringify(mutation.payload)
        );
      } else {
        localStorage.removeItem("expiration_date");
      }

      break;
  }
});
