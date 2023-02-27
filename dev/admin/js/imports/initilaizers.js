import { makeGetRequest } from "./helpers"
import UIkit from "uikit/dist/js/uikit.js"

export function initSortable() {
  UIkit.util.on(
    ".js-sortable",
    "moved",
    ({
      target: {
        children,
        dataset: { callback, param = `idList` },
      },
    }) => {
      const idList = [...children].map((el) => el.id)
      makeGetRequest(`${callback}&${param}=${idList}`)
    }
  )
}

export function initNetteAjax(documentOrElement = document) {
  ;[...documentOrElement.querySelectorAll(".ajax, [data-ajax]")].forEach(
    (element) => {
      if (element instanceof HTMLFormElement) {
        element.onsubmit = async (e) => {
          e.preventDefault()
          const formEntriesModified = await Promise.all(
            [...new FormData(element).entries()].map(formEntryWithoutBase64)
          )
          const body = new FormData()
          for (const [key, value] of formEntriesModified) {
            body.append(key, value)
          }
          await window.requestSnippets({
            endpoint: element.action,
            method: "POST",
            body,
            element,
          })
          element.reset()
        }
      }
      if (element instanceof HTMLAnchorElement) {
        element.onclick = async (e) => {
          e.preventDefault()
          await window.requestSnippets({
            endpoint: element.href,
            method: "GET",
            element,
          })
        }
      }
      if (
        element instanceof HTMLButtonElement ||
        (element instanceof HTMLInputElement && element.type === "button")
      ) {
        element.onclick = async (e) => {
          e.preventDefault()
          await window.requestSnippets({
            endpoint: element.dataset.ajax,
            method: "GET",
            element,
          })
        }
      }
      if (element.hasAttribute("uk-sortable")) {
        UIkit.util.on(
          element,
          "moved",
          async ({
            target: {
              children,
              dataset: { callback, param = `idList` },
            },
          }) => {
            const idList = [...children].map((el) => el.id)
            await window.requestSnippets({
              endpoint: callback,
              body: { [param]: idList },
              element,
            })
          }
        )
      }
    }
  )
}

async function formEntryWithoutBase64([name, value]) {
  try {
    if (!value.startsWith("data:image/png;base64")) {
      return [name, value]
    }
    const res = await fetch(value)
    const blob = await res.blob()
    return [name, new File([blob], name, { type: "image/png" })]
  } catch (e) {
    return [name, value]
  }
}

export async function initAll(documentOrElement = document) {
  if (window.Nette) {
    documentOrElement.querySelectorAll("form").forEach((form) => {
      window.Nette.initForm(form)
    })
  }
  initSortable(documentOrElement)
  initNetteAjax(documentOrElement)
}
