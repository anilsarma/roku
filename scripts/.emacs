;; .emacs

;;; uncomment this line to disable loading of "default.el" at startup
;; (setq inhibit-default-init t)

;; turn on font-lock mode
(when (fboundp 'global-font-lock-mode)
  (global-font-lock-mode t))

;; enable visual feedback on selections
;(setq transient-mark-mode t)

;; default to better frame titles
;;(setq frame-title-format
;;      (concat  "%b - emacs@" system-name))

;;(load-file "~/.emacs/init.el")



;;(global-set-key 'f1 'advertised-undo) ;; Undo
;;(global-set-key 'f2 'kill-primary-selection) ;; Cut
;;(global-set-key 'f2 'undo) ;;
;;(global-set-key (kbd "C-c") 'copy-primary-selection) ;; Copy4 
;;(global-set-key (kbd "C-v") 'yank-clipboard-selection) ;; Paste
;;(global-set-key 'f5 'find-file) ;; C-x C-f
(global-set-key [f7] 'compile) ;; C-x C-s
(global-set-key (kbd "M-g") 'goto-line)


(global-set-key (kbd "C-x /") 'point-to-register)
(global-set-key (kbd "C-x j") 'jump-to-register)	

;; Here's a sample .emacs file that might help you along the way.  Just
;; copy this region and paste it into your .emacs file.  You may want to
;; change some of the actual values.

(defconst my-c-style
  '((c-tab-always-indent        . t)
    (c-comment-only-line-offset . 0)
    (c-hanging-braces-alist     . ((substatement-open after)
                                   (brace-list-open)))

 ;;(member-init-intro before)
    ;;(inher-intro)
    (c-hanging-colons-alist     . (				   
                                   (case-label after)
                                   (label after)
                                   (access-label after)))

    (c-cleanup-list             . (scope-operator
                                   empty-defun-braces
                                   defun-close-semi))

    (c-offsets-alist            . ((arglist-close . c-lineup-arglist)
				   (arglist-intro  . 0 )
				   (inline-open    .    0 )
				   ;;(statement-cont . 0 )
                                   (substatement-open . 0)
                                   (case-label        . 4)
                                   (block-open        . 0)
                                   (knr-argdecl-intro . -)))
    (c-echo-syntactic-information-p . t)
    )
  "My C Programming Style")

;; emacs lookup 
;;http://sunsite.ualberta.ca/Documentation/Gnu/emacs-20.6/html_node/cc-mode_30.html

;; offset customizations not in my-c-style
(setq c-offsets-alist '((member-init-intro . ++)))



;;(c-indentation-style "user")


;;awk				   bsd
;;cc-mode				   ellemtel
;;gnu				   java
;;k&r				   linux
;;python				   stroustrup
;;user				   whitesmith
;; Customizations for all modes in CC Mode.
(defun my-c-mode-common-hook ()
  ;; add my personal style and set it for the current buffer
  (c-add-style "PERSONAL" my-c-style t)
  ;; other customizations
  (setq tab-width 4)
  ;; this will make sure spaces are used instead of tabs
  (indent-tabs-mode nil)
  ;; we like auto-newline and hungry-delete
  ;;(c-toggle-auto-hungry-state 1)
  ;; key bindings for all supported languages.  We can put these in
  ;; c-mode-base-map because c-mode-map, c++-mode-map, objc-mode-map,
  ;; java-mode-map, idl-mode-map, and pike-mode-map inherit from it.
  (define-key c-mode-base-map "\C-m" 'c-context-line-break)
  )

(add-hook 'c-mode-common-hook 'my-c-mode-common-hook)



;;; run gin on current word
(defun gid (word)
  (interactive "sWhat Word :")
  (if (equal word "" )
      (setq word (current-word)))
  (grep (format "gid  %s" word)))

(defun cscope (word)
  (interactive "sWhat Word :")
  (if (equal word "" )
      (setq word (current-word)))
  (grep (format "ccm.build.pl -cscope  %s" word)))

(defun cid (word)
  (interactive "sWhat Word :")
  (if (equal word "" )
      (setq word (current-word)))
  (grep (format "ccm.build.pl -cscope  %s" word)))

(defun p4edit (word)
  (interactive "fp4 edit File:")
  (if (equal word "" )
      (setq word (file-name-nondirectory (buffer-name))))
  (grep (format "p4 edit  %s" word)))

(global-set-key (kbd "C-x pe") 'p4edit)

;;(setq load-path (cons "/local_dev/as64720/work/Development/AMM/feedFi/ASXFeedAdaptor" load-path))
;;(load-library "~/.emacs.d/xcscope.elc")

;;(require 'xcscope)

;;(load-library "~/.emacs.d/cscope.el")
;;(require 'cscope)

(setq transient-mark-mode t)






;; help for registers
;; save to a register 
;;C-x r SPC r
;;    Save position of point in register r (point-to-register). 
;;C-x r j r
;;    Jump to the position saved in register r (jump-to-register). 

;; save text
;;C-x r s r
;;    Copy region into register r (copy-to-register). 
;;C-x r i r
;;    Insert text from register r (insert-register). 

;; save rectangle
;;C-x r r r
;;    Copy the region-rectangle into register r (copy-rectangle-to-register). With numeric argument, delete it as well. 
;;C-x r i r 

;; windows frames
;;C-x r w r
;;    Save the state of the selected frame's windows in register r (window-configuration-to-register). 
;;C-x r f r 
;;
;;C-x r m RET
;;    Set the bookmark for the visited file, at point. 
;;C-x r m bookmark RET
;;    Set the bookmark named bookmark at point (bookmark-set). 
;;C-x r b bookmark RET
;;    Jump to the bookmark named bookmark (bookmark-jump). 
;;C-x r l
;;    List all bookmarks (list-bookmarks). 
;;M-x bookmark-save Save all the current bookmark values in the default bookmark file. 
;;
;;(setq split-height-threshold nil)
;;(setq split-width-threshold 160)

;; split-window-horizontally



(custom-set-variables
  ;; custom-set-variables was added by Custom.
  ;; If you edit it by hand, you could mess it up, so be careful.
  ;; Your init file should contain only one such instance.
  ;; If there is more than one, they won't work right.
 '(transient-mark-mode t)
 '(uniquify-buffer-name-style (quote forward) nil (uniquify)))
(custom-set-faces
  ;; custom-set-faces was added by Custom.
  ;; If you edit it by hand, you could mess it up, so be careful.
  ;; Your init file should contain only one such instance.
  ;; If there is more than one, they won't work right.
 '(default ((t (:inherit nil :stipple nil :background "white" :foreground "black" :inverse-video nil :box nil :strike-through nil :overline nil :underline nil :slant normal :weight normal :height 125 :width normal :foundry "ibm" :family "Courier")))))




 (define-skeleton c-connection-test
      "Example for repeated input."
      "this prompt is ignored"
      ("Enter name of collection: " "for( iter="str ".begin(); iter !=" str ".end(); iter ++)" ))

;; -- http://www.emacswiki.org/cgi-bin/wiki/CategoryTemplates#toc2
(define-skeleton expand-for-collection
      "Iterator over a connection"
      nil
      >"for("
      (setq iter (skeleton-read "iterator name?"))
      >"="
      (setq c (skeleton-read "collection name?"))
      >".begin();" iter "!=" c ".end();" iter "++)" \n
      >"{" \n
      >"}" \n )

(setq skeleton-end-hook nil)

;; (. ccm.est.sh Release; export CCM_DEFAULT_VERSION=12.1.8-l;ccm.build.pl -compile -gen -cmake -O 0 -j 8 -il -remap -clean)

;;(. ccm.est.phlx.sh Release; export CCM_DEFAULT_VERSION=12.2.2;export CCM_FEEDFI_CAPI_VERSION=12.2.1; export CCM_FEEDFI_FEEDUTILS_VERSION=v1;export CCM_FEEDFI_SMGRTCP_VERSION=v1; ccm.build.pl -compile  -O 0 -j 8 -il -remap  -compile   -cmake -gen ) 
