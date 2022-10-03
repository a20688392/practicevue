import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.min.js";
import { Toast } from "bootstrap/dist/js/bootstrap.esm.min.js";

export default function AlterToast() {
  const Alter = () => {
    var toastLiveExample = document.getElementById("liveToast");
    var toast = new Toast(toastLiveExample);
    toast.show();
  };

  return {
    Alter,
  };
}
