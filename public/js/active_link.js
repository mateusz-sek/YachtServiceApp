  const links = document.querySelectorAll('#link');
  const currentPath = window.location.pathname;

  links.forEach(link => {
    if (link.getAttribute('href') === currentPath) {
      link.classList.add(
        'text-indigo-400',
        'relative',
        'after:absolute',
        'after:-bottom-2',
        'after:left-0',
        'after:w-full',
        'after:h-0.5',
        'after:bg-indigo-400',
        'after:rounded-full'
      );
    }
  });
